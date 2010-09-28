package em;

import java.util.Date;
import java.util.List;

/**
 *
 * @author gropher
 */
public class SfGuardUserProfileFacade {

    private Context context;

    public SfGuardUserProfileFacade(Context context) {
        this.context = context;
    }

    public SfGuardUserProfile create(SfGuardUserProfile sfGuardUserProfile) {
        context.getEntityManager().persist(sfGuardUserProfile);
        context.getEntityManager().flush();
        return sfGuardUserProfile;
    }

    public void edit(SfGuardUserProfile sfGuardUserProfile) {
        sfGuardUserProfile.setUpdatedAt(new Date());
        context.getEntityManager().merge(sfGuardUserProfile);
    }

    public void remove(SfGuardUserProfile sfGuardUserProfile) {
        context.getEntityManager().remove(context.getEntityManager().merge(sfGuardUserProfile));
    }

    public SfGuardUserProfile find(Object id) {
        return context.getEntityManager().find(SfGuardUserProfile.class, id);
    }

    public List<SfGuardUserProfile> findAll() {
        return context.getEntityManager().createQuery("select object(o) from SfGuardUserProfile as o").getResultList();
    }
}
