package em;

import java.util.Date;
import java.util.List;

/**
 *
 * @author gropher
 */
public class PostCommentFacade {

    private Context context;

    public PostCommentFacade(Context context) {
        this.context = context;
    }

    public void create(PostComment postComment) {
        context.getEntityManager().persist(postComment);

        Post post = postComment.getPostId();
        context.getEntityManager().refresh(post);
        post.setRating(post.getRating() + 0.3);
        post.setCommentsCount(post.getCommentsCount() + 1);
        context.getPostFacade().edit(post);

        SfGuardUserProfile profile = post.getUserId().getProfile();
        context.getEntityManager().refresh(profile);
        profile.setRating(profile.getRating() + 0.3);
        context.getSfGuardUserProfileFacade().edit(profile);

        profile = postComment.getUserId().getProfile();
        context.getEntityManager().refresh(profile);
        profile.setRating(profile.getRating() + 0.3);
        context.getSfGuardUserProfileFacade().edit(profile);
        
        context.getEntityManager().flush();
    }

    public void edit(PostComment postComment) {
        postComment.setUpdatedAt(new Date());
        context.getEntityManager().merge(postComment);
        context.getEntityManager().flush();
    }

    public void remove(PostComment postComment) {
        Post post = postComment.getPostId();
        context.getEntityManager().refresh(post);
        post.setRating(post.getRating() - 0.3);
        post.setCommentsCount(post.getCommentsCount() - 1);
        context.getPostFacade().edit(post);

        SfGuardUserProfile profile = post.getUserId().getProfile();
        context.getEntityManager().refresh(profile);
        profile.setRating(profile.getRating() - 0.3);
        context.getSfGuardUserProfileFacade().edit(profile);

        profile = postComment.getUserId().getProfile();
        context.getEntityManager().refresh(profile);
        profile.setRating(profile.getRating() - 0.3);
        context.getSfGuardUserProfileFacade().edit(profile);
        context.getEntityManager().refresh(postComment);
        for (PostComment comment : postComment.getPostCommentCollection()) {
            this.remove(comment);
        }
        context.getEntityManager().remove(context.getEntityManager().merge(postComment));
        context.getEntityManager().flush();
    }

    public PostComment find(Object id) {
        return context.getEntityManager().find(PostComment.class, id);
    }

    public List<PostComment> findAll(int limit, Boolean isNew) {
        return context.getEntityManager().createQuery("select object(c) from PostComment as c where c.isnew = :isnew").setParameter("isnew", isNew).setMaxResults(limit).getResultList();
    }
}
