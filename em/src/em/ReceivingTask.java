package em;

import java.security.NoSuchProviderException;
import java.util.LinkedList;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.mail.Flags;
import javax.mail.MessagingException;
import javax.mail.Multipart;
import javax.mail.Part;
import javax.mail.internet.InternetAddress;

/**
 *
 * @author gropher
 */
public class ReceivingTask implements Runnable {

    private Context context;

    public ReceivingTask(Context context) {
        this.context = context;
    }

    public void run() {
        while (true) {
            try {
                doWork();
                Thread.sleep(1000);
            } catch (Exception ex) {
                Logger.getLogger(SendingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    public void doWork() {
        if (context.beginTransaction()) {
            System.out.println("Receiving: begin transaction");
            try {
                if(context.USE_MAIL)
                    receiveMail();
            } catch (Exception ex) {
                Logger.getLogger(ReceivingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
            try {
                if(context.USE_JABBER)
                    receiveJabberMessages();
            } catch (Exception ex) {
                Logger.getLogger(ReceivingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
            try {
                if(context.USE_JABBER)
                    receiveJabberPresence();
            } catch (Exception ex) {
                Logger.getLogger(ReceivingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
            try {
                if(context.USE_ICQ)
                    receiveIcqMessages();
            } catch (Exception ex) {
                Logger.getLogger(ReceivingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
            try {
                if(context.USE_ICQ)
                    receiveIcqPresence();
            } catch (Exception ex) {
                Logger.getLogger(ReceivingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
            context.commitTransaction();
            System.out.println("Receiving: commit transaction");
        } else {
            System.out.println("Receiving: waiting transaction");
        }
    }

    private void receiveMail() throws MessagingException, NoSuchProviderException {
        javax.mail.Message[] messages = context.getMessaging().receiveMail();
        for (javax.mail.Message m : messages) {
            try {
                m.setFlag(Flags.Flag.DELETED, true);
                String address = ((InternetAddress) m.getFrom()[0]).getAddress();
                SfGuardUser user = context.getSfGuardUserFacade().findByEmail(address);
                if (user != null) {
                    String messageText = "";
                    boolean hasHTML = false;
                    LinkedList<MessageAttachment> attachments = new LinkedList();
                    if (m.getContent() instanceof Multipart) {
                        Multipart multipart = (Multipart) m.getContent();
                        for (int i = 0, n = multipart.getCount(); i < n; i++) {
                            Part part = multipart.getBodyPart(i);
                            String disposition = part.getDisposition();
                            if (disposition == null) {
                                if (part.getContent() instanceof Multipart) {
                                    Multipart body = (Multipart) part.getContent();
                                    for (int j = 0, l = body.getCount(); j < l; j++) {
                                        Part bodyPart = body.getBodyPart(j);
                                        if (!hasHTML && bodyPart.isMimeType("text/plain")) {
                                            messageText = bodyPart.getContent().toString();
                                        } else if (bodyPart.isMimeType("text/html")) {
                                            hasHTML = true;
                                            messageText = bodyPart.getContent().toString();
                                        }
                                    }
                                } else {
                                    if (!hasHTML && part.isMimeType("text/plain")) {
                                        messageText = part.getContent().toString();
                                    } else if (part.isMimeType("text/html")) {
                                        hasHTML = true;
                                        messageText = part.getContent().toString();
                                    }
                                }
                            } else if (disposition.equalsIgnoreCase(Part.ATTACHMENT) || disposition.equalsIgnoreCase(Part.INLINE)) {
                                String attachValue = context.getSiteApi().saveImageFile(part.getFileName(), part.getInputStream());
                                if (!attachValue.equalsIgnoreCase("")) {
                                    attachments.add(new MessageAttachment("picture", attachValue));
                                }
                            }
                        }
                    } else {
                        messageText = m.getContent().toString();
                    }
                    Message dbMessage = new Message(user, "incoming", "unknown", "pop", "new", address, messageText);
                    if (!context.getMessageFacade().isBounceMessage(dbMessage)) {
                        context.getMessageFacade().create(dbMessage);
                        for (MessageAttachment a : attachments) {
                            a.setMessageId(dbMessage);
                            context.getMessageAttachementFacade().create(a);
                            dbMessage.getMessageAttachmentCollection().add(a);
                        }
                        System.out.println("Receiving: email from '" + dbMessage.getEmail() + "' type: " + dbMessage.getType());
                    }
                } else {
                    context.getMessaging().sendMail(((InternetAddress) m.getFrom()[0]).getAddress(), "Здравствуйте!\n<br>" +
                            "Для того, чтобы использовать систему рассылки сообщений сайта "+context.SITE_NAME+", Вам нужно <a href='"+context.SITE_URL+"/register'>зарегистрироваться</a> на нашем сайте и указать в <a href='http://joyreactor.ru/settings'>настройках</a> свой e-mail.\n");
                }
            } catch (Exception ex) {
                Logger.getLogger(ReceivingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        context.getMessaging().submitMail();
    }

    private void receiveJabberMessages() {
        org.jivesoftware.smack.packet.Message[] messages = new org.jivesoftware.smack.packet.Message[0];
        messages = context.getMessaging().receiveJabberMessages();
        for (org.jivesoftware.smack.packet.Message m : messages) {
            try {
                SfGuardUser user = context.getSfGuardUserFacade().findByJabber(m.getFrom().split("/")[0].toLowerCase());
                if (user != null && m.getBody() != null) {
                    Message dbMessage = new Message(user, "incoming", "unknown", "xmpp", "new", m.getFrom(), m.getBody());
                    if (!context.getMessageFacade().isBounceMessage(dbMessage)) {
                        context.getMessageFacade().create(dbMessage);
                        System.out.println("Receiving: jabber from '" + dbMessage.getJabber() + "' type: " + dbMessage.getType());
                    }
                } else if (user == null && m.getBody() != null) {
                    context.getMessaging().sendJabberMessage(m.getFrom(), "Здравствуйте!\n" +
                            "Для того, чтобы использовать систему рассылки сообщений сайта "+context.SITE_NAME+", Вам нужно зарегистрироваться ("+context.SITE_URL+"/register) на нашем сайте и указать в настройках ("+context.SITE_URL+"/settings) свой jabber-адрес.\n");
                }
            } catch (Exception ex) {
                Logger.getLogger(ReceivingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    private void receiveJabberPresence() {
        org.jivesoftware.smack.packet.Presence[] messages = new org.jivesoftware.smack.packet.Presence[0];
        messages = context.getMessaging().receiveJabberPresence();
        for (org.jivesoftware.smack.packet.Presence m : messages) {
            try {
                SfGuardUser user = context.getSfGuardUserFacade().findByJabber(m.getFrom().split("/")[0].toLowerCase());
                if (user != null) {
                    SfGuardUserProfile profile = user.getProfile();
                    if (profile.getCollectJabberStatus()) {
                        Message dbMessage = new Message(user, "incoming", "jabberStatus", "xmpp", "new", m.getFrom(), m.getStatus());
                        if (!context.getMessageFacade().isBounceMessage(dbMessage)) {
                            context.getMessageFacade().create(dbMessage);
                            System.out.println("Receiving: jabber presence from '" + dbMessage.getJabber() + "' type: " + dbMessage.getType());
                        }
                    }
                }
            } catch (Exception ex) {
                Logger.getLogger(ReceivingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    private void receiveIcqMessages() {
        org.jivesoftware.smack.packet.Message[] messages = new org.jivesoftware.smack.packet.Message[0];
        messages = context.getMessaging().receiveIcqMessages();
        for (org.jivesoftware.smack.packet.Message m : messages) {
            try {
                String address = m.getFrom().split("@")[0].toLowerCase();
                SfGuardUser user = context.getSfGuardUserFacade().findByIcq(address);
                if (user != null && m.getBody() != null) {
                    Message dbMessage = new Message(user, "incoming", "unknown", "icq", "new", address, m.getBody());
                    if (!context.getMessageFacade().isBounceMessage(dbMessage)) {
                        context.getMessageFacade().create(dbMessage);
                        System.out.println("Receiving: icq from '" + dbMessage.getIcq() + "' type: " + dbMessage.getType());
                    }
                } else if (user == null && m.getBody() != null) {
                    context.getMessaging().sendIcqMessage(m.getFrom(), "Здравствуйте!\n" +
                            "Для того, чтобы использовать систему рассылки сообщений сайта "+context.SITE_NAME+", Вам нужно зарегистрироваться ("+context.SITE_URL+"/register) на нашем сайте и указать в настройках ("+context.SITE_URL+"/settings) свой номер ICQ.\n");
                }
            } catch (Exception ex) {
                Logger.getLogger(ReceivingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    private void receiveIcqPresence() {
        org.jivesoftware.smack.packet.Presence[] messages = new org.jivesoftware.smack.packet.Presence[0];
        messages = context.getMessaging().receiveIcqPresence();
        for (org.jivesoftware.smack.packet.Presence m : messages) {
            try {
                String address = m.getFrom().split("@")[0].toLowerCase();
                SfGuardUser user = context.getSfGuardUserFacade().findByIcq(address);
                if (user != null) {
                    SfGuardUserProfile profile = user.getProfile();
                    if (profile.getCollectIcqStatus()) {
                        Message dbMessage = new Message(user, "incoming", "icqStatus", "icq", "new", address, m.getStatus());
                        if (!context.getMessageFacade().isBounceMessage(dbMessage)) {
                            context.getMessageFacade().create(dbMessage);
                            System.out.println("Receiving: icq presence from '" + dbMessage.getIcq() + "' type: " + dbMessage.getType());
                        }
                    }
                }
            } catch (Exception ex) {
                Logger.getLogger(ReceivingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
}
