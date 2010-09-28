/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package em;

import java.util.Date;
import java.util.List;

/**
 *
 * @author gropher
 */
public class PostFacade {

    private Context context;

    public PostFacade(Context context) {
        this.context = context;
    }

    public Post create(Post post) {
        context.getEntityManager().persist(post);
        context.getEntityManager().flush();
        if(post.getType().equalsIgnoreCase("post"))
            context.getSiteApi().postCreateTrigger(post);
        return post;
    }

    public void edit(Post post) {
        post.setUpdatedAt(new Date());
        context.getEntityManager().merge(post);
        context.getEntityManager().flush();
    }

    public void remove(Post post) {
        SfGuardUserProfile profile = post.getUserId().getProfile();
        context.getEntityManager().refresh(profile);
        profile.setRating(profile.getRating() - post.getRating());
        context.getSfGuardUserProfileFacade().edit(profile);
        context.getEntityManager().remove(context.getEntityManager().merge(post));
    }

    public Post find(Object id) {
        return context.getEntityManager().find(Post.class, id);
    }

    public List<Post> findAll(int limit, Boolean isNew) {
        return context.getEntityManager().createQuery("select object(p) from Post as p where p.isnew = :isnew and p.type = :type")
                .setParameter("isnew", isNew).setParameter("type", "post").setMaxResults(limit).getResultList();
    }

    public List<Post> findAllCrossposting(int limit) {
        return context.getEntityManager().createQuery("select object(p) from Post as p where p.lj = :lj and p.type = :type and p.rating >= :rating")
                .setParameter("lj", false).setParameter("type", "post").setParameter("rating", context.MAIN_PAGE_THRESHOLD).setMaxResults(limit).getResultList();
    }
}
