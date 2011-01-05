package em;

import java.security.NoSuchProviderException;
import java.util.Collection;
import java.util.LinkedList;
import java.util.Properties;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.mail.Folder;
import javax.mail.MessagingException;
import javax.mail.Session;
import javax.mail.Store;
import javax.mail.Transport;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;
import org.jivesoftware.smack.ConnectionConfiguration;
import org.jivesoftware.smack.PacketListener;
import org.jivesoftware.smack.Roster;
import org.jivesoftware.smack.Roster.SubscriptionMode;
import org.jivesoftware.smack.RosterGroup;
import org.jivesoftware.smack.RosterListener;
import org.jivesoftware.smack.SASLAuthentication;
import org.jivesoftware.smack.XMPPConnection;
import org.jivesoftware.smack.XMPPException;
import org.jivesoftware.smack.filter.PacketFilter;
import org.jivesoftware.smack.filter.PacketTypeFilter;
import org.jivesoftware.smack.packet.Packet;
import org.jivesoftware.smack.packet.Presence;

/**
 *
 * @author gropher
 */
public class Messaging {

    private Context context;
    private volatile LinkedList<org.jivesoftware.smack.packet.Message> jabberMessages = new LinkedList();
    private volatile LinkedList<org.jivesoftware.smack.packet.Presence> jabberPresence = new LinkedList();
    private volatile LinkedList<org.jivesoftware.smack.packet.Message> icqMessages = new LinkedList();
    private volatile LinkedList<org.jivesoftware.smack.packet.Presence> icqPresence = new LinkedList();
    private volatile XMPPConnection connection = null;
    private volatile XMPPConnection icqConnection = null;
    private volatile Session session = Session.getDefaultInstance(new Properties());
    private volatile Store store = null;
    private volatile Folder folder = null;
    private volatile Transport transport = null;
    private volatile String statusText = "Отправь @h для вывода помощи";
    private PacketFilter filter = new PacketTypeFilter(org.jivesoftware.smack.packet.Message.class);
    private PacketListener listener = new PacketListener() {

        public void processPacket(Packet packet) {
            try {
                org.jivesoftware.smack.packet.Message msg = (org.jivesoftware.smack.packet.Message) packet;
                if(msg.getType() != org.jivesoftware.smack.packet.Message.Type.error && !msg.getFrom().split("@")[1].equalsIgnoreCase(context.ICQ_TRANSPORT))
                    jabberMessages.add(msg);
            } catch (Exception ex) {
                Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
                restartJabber();
            }
        }
    };
    private RosterListener rosterListener = new RosterListener() {

        public void entriesAdded(Collection<String> arg0) {
            Roster roster = connection.getRoster();
            RosterGroup gr = roster.getGroup("Users");
            if(gr == null)
                gr = roster.createGroup("Users");
            for(String entry : arg0 ) {
                try {
                    String[] groups = {"Users"};
                    if(roster.getEntry(entry) == null)
                        roster.createEntry(entry, null, groups);
                } catch (XMPPException ex) {
                    Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
        }

        public void entriesUpdated(Collection<String> arg0) {
            Roster roster = connection.getRoster();
            RosterGroup gr = roster.getGroup("Users");
            if(gr == null)
                gr = roster.createGroup("Users");
            for(String entry : arg0 ) {
                try {
                    String[] groups = {"Users"};
                    if(roster.getEntry(entry) == null)
                        roster.createEntry(entry, null, groups);
                } catch (XMPPException ex) {
                    Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
        }

        public void entriesDeleted(Collection<String> arg0) {
        }

        public void presenceChanged(Presence packet) {
            try {
                org.jivesoftware.smack.packet.Presence prs = (org.jivesoftware.smack.packet.Presence) packet;
                if(!prs.getFrom().equalsIgnoreCase(context.ICQ_TRANSPORT) && !prs.getFrom().split("@")[1].equalsIgnoreCase(context.ICQ_TRANSPORT))
                    jabberPresence.add(prs);
            } catch (Exception ex) {
                Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    };
    private PacketListener icqListener = new PacketListener() {

        public void processPacket(Packet packet) {
            try {
                org.jivesoftware.smack.packet.Message msg = (org.jivesoftware.smack.packet.Message) packet;
                if(msg.getType() != org.jivesoftware.smack.packet.Message.Type.error &&
                   msg.getFrom().split("@")[1].equalsIgnoreCase(context.ICQ_TRANSPORT))
                    icqMessages.add(msg);
            } catch (Exception ex) {
                restartIcq();
                Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    };
    private RosterListener icqRosterListener = new RosterListener() {

        public void entriesAdded(Collection<String> arg0) {
            Roster roster = icqConnection.getRoster();
            RosterGroup gr = roster.getGroup("Users");
            if(gr == null)
                gr = roster.createGroup("Users");
            for(String entry : arg0 ) {
                try {
                    String[] groups = {"Users"};
                    if(roster.getEntry(entry) == null)
                        roster.createEntry(entry, null, groups);
                } catch (XMPPException ex) {
                    Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
        }

        public void entriesUpdated(Collection<String> arg0) {
            Roster roster = icqConnection.getRoster();
            RosterGroup gr = roster.getGroup("Users");
            if(gr == null)
                gr = roster.createGroup("Users");
            for(String entry : arg0 ) {
                try {
                    String[] groups = {"Users"};
                    if(roster.getEntry(entry) == null)
                        roster.createEntry(entry, null, groups);
                } catch (XMPPException ex) {
                    Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
                }
            }
        }

        public void entriesDeleted(Collection<String> arg0) {
        }

        public void presenceChanged(Presence packet) {
            try {
                org.jivesoftware.smack.packet.Presence prs = (org.jivesoftware.smack.packet.Presence) packet;
                if(prs.getType() != Presence.Type.error && prs.getFrom().contains("@") &&
                   prs.getFrom().split("@")[1].equalsIgnoreCase(context.ICQ_TRANSPORT))
                    icqPresence.add(prs);
            } catch (Exception ex) {
                Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    };

    public Messaging(Context context) {
        this.context = context;
    }

    public boolean sendMail(String toAddress, String text) throws MessagingException {
        MimeMessage message = new MimeMessage(session);
        message.setFrom(new InternetAddress("noreply@joyreactor.ru"));
        try {
            message.addRecipient(javax.mail.Message.RecipientType.TO, new InternetAddress(toAddress));
        } catch (Exception ex) {
            Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
            return false;
        }
        message.setSubject("JoyReactor");
        message.setText(text, "UTF-8", "html");
        transport = session.getTransport("smtp");
        transport.connect(context.SMTP_HOST, context.SMTP_LOGIN, context.SMTP_PASS);
        transport.sendMessage(message, message.getAllRecipients());
        transport.close();
        return true;
    }

    public synchronized javax.mail.Message[] receiveMail() throws NoSuchProviderException, MessagingException {
        store = session.getStore("pop3");
        store.connect(context.POP_HOST, context.POP_LOGIN, context.POP_PASS);
        folder = store.getFolder("INBOX");
        folder.open(Folder.READ_WRITE);
        javax.mail.Message[] messages = folder.getMessages();
        return messages;
    }

    public synchronized void submitMail() throws MessagingException {
        folder.close(true);
        store.close();
    }

    public synchronized org.jivesoftware.smack.packet.Message[] receiveJabberMessages() {
        org.jivesoftware.smack.packet.Message[] res = new org.jivesoftware.smack.packet.Message[0];
        res = jabberMessages.toArray(res);
        jabberMessages.clear();
        return res;
    }

    public synchronized org.jivesoftware.smack.packet.Presence[] receiveJabberPresence() {
        org.jivesoftware.smack.packet.Presence[] res = new org.jivesoftware.smack.packet.Presence[0];

        res = jabberPresence.toArray(res);
        jabberPresence.clear();
        return res;
    }

    public synchronized org.jivesoftware.smack.packet.Message[] receiveIcqMessages() {
        org.jivesoftware.smack.packet.Message[] res = new org.jivesoftware.smack.packet.Message[0];
        res = icqMessages.toArray(res);
        icqMessages.clear();
        return res;
    }

    public synchronized org.jivesoftware.smack.packet.Presence[] receiveIcqPresence() {
        org.jivesoftware.smack.packet.Presence[] res = new org.jivesoftware.smack.packet.Presence[0];
        res = icqPresence.toArray(res);
        icqPresence.clear();
        return res;
    }

    public boolean sendJabberMessage(String toAddress, String text) throws XMPPException {
        org.jivesoftware.smack.packet.Message message = null;
        try {
            message = new org.jivesoftware.smack.packet.Message(toAddress);
        } catch (Exception e) {
            return false;
        }
        message.setBody(text);
        connection.sendPacket(message);
        return true;
    }

    public boolean sendIcqMessage(String toAddress, String text) throws XMPPException {
        org.jivesoftware.smack.packet.Message message = null;
        try {
            message = new org.jivesoftware.smack.packet.Message(toAddress+"@"+context.ICQ_TRANSPORT);
        } catch (Exception e) {
            return false;
        }
        message.setBody(text);
        icqConnection.sendPacket(message);
        return true;
    }

    public void startMessaging() {
        if(context.USE_JABBER)
            startJabber();
        if(context.USE_ICQ)
            startIcq();
    }

    public void stopMessaging() {
        stopJabber();
        stopIcq();
    }

    public void restartJabber() {
        stopJabber();
        startJabber();
    }

    public void restartIcq() {
        stopIcq();
        startIcq();
    }

    public Boolean isJabberConnected() {
        Boolean res = connection != null && connection.isConnected();
        return res;
    }

    public Boolean isIcqConnected() {
        Boolean res = icqConnection != null && icqConnection.isConnected();
        return res;
    }

    private void startIcq() {
        try {
            Roster.setDefaultSubscriptionMode(SubscriptionMode.accept_all);
            icqConnection = new XMPPConnection(context.ICQ_HOST);
            icqConnection.connect();
            SASLAuthentication.supportSASLMechanism("PLAIN", 0);
            icqConnection.login(context.ICQ_LOGIN, context.ICQ_PASS, "icqbot");
            icqConnection.getRoster().addRosterListener(icqRosterListener);
            icqConnection.addPacketListener(icqListener, filter);
        } catch (Exception ex) {
            Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    private void stopIcq() {
        try {
            if (icqConnection != null && icqConnection.isConnected()) {
                icqConnection.disconnect();
            }
        } catch (Exception ex) {
            Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
        }
        icqConnection = null;
    }

    private void startJabber() {
        try {
            Roster.setDefaultSubscriptionMode(SubscriptionMode.accept_all);
            ConnectionConfiguration config = new ConnectionConfiguration(context.JABBER_HOST);
            config.setNotMatchingDomainCheckEnabled(false);
            connection = new XMPPConnection(config);
            connection.connect();
            SASLAuthentication.supportSASLMechanism("PLAIN", 0);
            connection.login(context.JABBER_LOGIN, context.JABBER_PASS, "jabberbot");
            connection.getRoster().addRosterListener(rosterListener);
            Presence presence = new Presence(Presence.Type.available, statusText, 1, Presence.Mode.available);
            connection.sendPacket(presence);
            connection.addPacketListener(listener, filter);
        } catch (Exception ex) {
            Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    private void stopJabber() {
        try {
            if (connection != null && connection.isConnected()) {
                connection.disconnect();
            }
        } catch (Exception ex) {
            Logger.getLogger(Messaging.class.getName()).log(Level.SEVERE, null, ex);
        }
        connection = null;
    }
}
