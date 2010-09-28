package em;

import java.util.Date;

/**
 *
 * @author gropher
 */
public class MessageAttachmentFacade {

    private Context context;

    public MessageAttachmentFacade(Context context) {
        this.context = context;
    }

    public MessageAttachment create(MessageAttachment messageAttachment) {
        context.getEntityManager().persist(messageAttachment);
        context.getEntityManager().flush();
        return messageAttachment;
    }

    public void edit(MessageAttachment messageAttachment) {
        messageAttachment.setUpdatedAt(new Date());
        context.getEntityManager().merge(messageAttachment);
    }

    public void remove(MessageAttachment messageAttachment) {
        context.getEntityManager().remove(context.getEntityManager().merge(messageAttachment));
    }

    public MessageAttachment find(Object id) {
        return context.getEntityManager().find(MessageAttachment.class, id);
    }
}
