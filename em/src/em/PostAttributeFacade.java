package em;

import java.util.Date;

/**
 *
 * @author gropher
 */
public class PostAttributeFacade {

    private Context context;

    public PostAttributeFacade(Context context) {
        this.context = context;
    }

    public PostAttribute create(PostAttribute postAttribute) {
        context.getEntityManager().persist(postAttribute);
        context.getEntityManager().flush();
        return postAttribute;
    }

    public void edit(PostAttribute postAttribute) {
        postAttribute.setUpdatedAt(new Date());
        context.getEntityManager().merge(postAttribute);
    }

    public void remove(PostAttribute postAttribute) {
        context.getEntityManager().remove(context.getEntityManager().merge(postAttribute));
    }

    public PostAttribute find(Object id) {
        return context.getEntityManager().find(PostAttribute.class, id);
    }
}
