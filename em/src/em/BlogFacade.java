package em;

import java.util.Date;
import javax.persistence.NoResultException;

/**
 *
 * @author gropher
 */
public class BlogFacade {

    private Context context;

    public BlogFacade(Context context) {
        this.context = context;
    }

    public void create(Blog blog) {
        context.getEntityManager().persist(blog);
    }

    public void edit(Blog blog) {
        blog.setUpdatedAt(new Date());
        context.getEntityManager().merge(blog);
    }

    public void remove(Blog blog) {
        context.getEntityManager().remove(context.getEntityManager().merge(blog));
    }

    public Blog find(Object id) {
        return context.getEntityManager().find(Blog.class, id);
    }

    public Blog findByTag(String tag) {
        try {
            return (Blog) context.getEntityManager().createQuery("select object(b) from Blog b  where b.tag = :tag").setParameter("tag", tag).getSingleResult();
        } catch (NoResultException ex) {
            return null;
        }
    }

    public Blog findByTagOrCreate(String tag, SfGuardUser user) {
        try {
            return (Blog) context.getEntityManager().createQuery("select object(b) from Blog b  where b.tag = :tag").setParameter("tag", tag).getSingleResult();
        } catch (NoResultException ex) {
            Blog blog = new Blog();
            blog.setName(tag);
            blog.setTag(tag);
            blog.setUserId(user);
            this.create(blog);
            return blog;
        }
    }
}
