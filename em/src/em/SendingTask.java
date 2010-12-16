package em;

import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author gropher
 */
public class SendingTask implements Runnable {

    private Context context;

    public SendingTask(Context context) {
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

    private void doWork() {
        if (context.beginTransaction()) {
            System.out.println("Sending: start");
            try {
                if(context.USE_MAIL)
                    sendEmails(context.getMessageFacade().findAll(10, "outgoing", "new", "smtp"));
            } catch (Exception ex) {
                Logger.getLogger(SendingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
            try {
                if(context.USE_JABBER)
                    sendJabberMessages(context.getMessageFacade().findAll(10, "outgoing", "new", "xmpp"));
            } catch (Exception ex) {
                Logger.getLogger(SendingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
            try {
                if(context.USE_ICQ)
                    sendIcqMessages(context.getMessageFacade().findAll(10, "outgoing", "new", "icq"));
            } catch (Exception ex) {
                Logger.getLogger(SendingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
            context.commitTransaction();
            System.out.println("Sending: end");
        } else {
            System.out.println("Sending: WAIT");
        }
    }

    private void sendJabberMessages(List<Message> messages) {
        for (Message m : messages) {
            try {
                if(context.getMessaging().sendJabberMessage(m.getJabber(), m.getText())) {
                    m.setStatus("sent");
                    System.out.println("Sending: jabber sent to '"+m.getJabber()+"' type: "+m.getType());
                } else {
                    m.setStatus("error");
                    System.out.println("Sending: error sending jabber to '"+m.getJabber()+"' type: "+m.getType());
                }
                context.getMessageFacade().edit(m);
            } catch (Exception ex) {
                Logger.getLogger(SendingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    private void sendIcqMessages(List<Message> messages) {
        for (Message m : messages) {
            try {
                if(context.getMessaging().sendIcqMessage(m.getIcq(), m.getText())) {
                    m.setStatus("sent");
                    System.out.println("Sending: icq sent to '"+m.getIcq()+"' type: "+m.getType());
                } else {
                    m.setStatus("error");
                    System.out.println("Sending: error sending icq to '"+m.getJabber()+"' type: "+m.getType());
                }
                context.getMessageFacade().edit(m);
            } catch (Exception ex) {
                Logger.getLogger(SendingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    private void sendEmails(List<Message> messages) {
        for (Message m : messages) {
            try {
                if(context.getMessaging().sendMail(m.getEmail(), m.getText())) {
                    m.setStatus("sent");
                    System.out.println("Sending: email sent to '"+m.getEmail()+"' type: "+m.getType());
                } else {
                    m.setStatus("error");
                    System.out.println("Sending: error sending email to '"+m.getEmail()+"' type: "+m.getType());
                }
                context.getMessageFacade().edit(m);
            } catch (Exception ex) {
                Logger.getLogger(SendingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
}