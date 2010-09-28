package em;

import java.util.Date;

/**
 *
 * @author gropher
 */
public class BlogPostFacade {

    private Context context;

    public BlogPostFacade(Context context) {
        this.context = context;
    }

    public void create(BlogPost bp) {
        context.getEntityManager().persist(bp);
    }

    public void edit(BlogPost bp) {
        bp.setUpdatedAt(new Date());
        context.getEntityManager().merge(bp);
    }

    public void remove(BlogPost bp) {
        context.getEntityManager().remove(context.getEntityManager().merge(bp));
    }

    public BlogPost find(Object id) {
        return context.getEntityManager().find(BlogPost.class, id);
    }
}
