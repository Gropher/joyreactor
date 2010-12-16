package em;

import java.util.TimeZone;
import javax.persistence.EntityManager;
import javax.persistence.EntityManagerFactory;
import javax.persistence.Persistence;

/**
 *
 * @author gropher
 */
public class Context {
    public static Context instance;

    public final String SITE_URL = "http://empaty";
    public final String SITE_NAME = "empaty";

    public final Boolean USE_JABBER = true;
    public final String JABBER_HOST = "empaty";
    public final String JABBER_LOGIN = "em";
    public final String JABBER_PASS = "justpassme";

    public final Boolean USE_ICQ = true;
    public final String ICQ_HOST = "jabber.localhost";
    public final String ICQ_TRANSPORT = "icq.jabber.localhost";
    public final String ICQ_LOGIN = "em";
    public final String ICQ_PASS = "justpassme";

    public final Boolean USE_MAIL = true;
    public final String POP_HOST = "localhost";
    public final String POP_LOGIN = "em";
    public final String POP_PASS = "justpassme";
    public final String SMTP_HOST = "localhost";
    public final String SMTP_LOGIN = "em";
    public final String SMTP_PASS = "justpassme";

    public final String CROSSPOSTING_NAME = "empaty";
    public final String CROSSPOSTING_PASS = "justpassme";
    public final double MAIN_PAGE_THRESHOLD = 1;
    
    private volatile Messaging messaging;
    private volatile BlogFacade blogFacade;
    private volatile BlogPostFacade blogPostFacade;
    private volatile MessageFacade messageFacade;
    private volatile PostCommentFacade postCommentFacade;
    private volatile PostFacade postFacade;
    private volatile SfGuardUserFacade sfGuardUserFacade;
    private volatile SfGuardUserProfileFacade sfGuardUserProfileFacade;
    private volatile MessageAttachmentFacade messageAttachementFacade;
    private volatile PostAttributeFacade postAttributeFacade;
    private volatile EntityManager em;
    private volatile SiteAPI siteApi;

    public Context() {
        TimeZone.setDefault(TimeZone.getTimeZone("Europe/Moscow"));
        EntityManagerFactory emf = Persistence.createEntityManagerFactory("emPU");
        em = emf.createEntityManager();
        messaging = new Messaging(this);
        blogFacade = new BlogFacade(this);
        blogPostFacade = new BlogPostFacade(this);
        messageFacade = new MessageFacade(this);
        messageAttachementFacade = new MessageAttachmentFacade(this);
        postCommentFacade = new PostCommentFacade(this);
        postAttributeFacade = new PostAttributeFacade(this);
        postFacade = new PostFacade(this);
        sfGuardUserFacade = new SfGuardUserFacade(this);
        sfGuardUserProfileFacade = new SfGuardUserProfileFacade(this);
        siteApi = new SiteAPI(this);
        Context.instance = this;
    }

    public PostAttributeFacade getPostAttributeFacade() {
        return postAttributeFacade;
    }

    public MessageAttachmentFacade getMessageAttachementFacade() {
        return messageAttachementFacade;
    }

    public MessageFacade getMessageFacade() {
        return messageFacade;
    }

    public BlogFacade getBlogFacade() {
        return blogFacade;
    }

    public BlogPostFacade getBlogPostFacade() {
        return blogPostFacade;
    }

    public Messaging getMessaging() {
        return messaging;
    }

    public PostCommentFacade getPostCommentFacade() {
        return postCommentFacade;
    }

    public PostFacade getPostFacade() {
        return postFacade;
    }

    public SfGuardUserFacade getSfGuardUserFacade() {
        return sfGuardUserFacade;
    }

    public SfGuardUserProfileFacade getSfGuardUserProfileFacade() {
        return sfGuardUserProfileFacade;
    }

    public EntityManager getEntityManager() {
        return em;
    }

    public SiteAPI getSiteApi() {
        return siteApi;
    }

    public synchronized Boolean beginTransaction() {
        if (em.getTransaction().isActive()) {
            return false;
        }
        em.getTransaction().begin();
        return true;
    }

    public void commitTransaction() {
        em.getTransaction().commit();
    }

    public void rollbackTransaction() {
        em.getTransaction().rollback();
    }
}
