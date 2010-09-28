package em;

import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.List;
import javax.persistence.NoResultException;

/**
 *
 * @author gropher
 */
public class SfGuardUserFacade {

    private Context context;

    public SfGuardUserFacade(Context context) {
        this.context = context;
    }

    public SfGuardUser create(SfGuardUser sfGuardUser) {
        context.getEntityManager().persist(sfGuardUser);
        context.getEntityManager().flush();
        return sfGuardUser;

    }

    public void edit(SfGuardUser sfGuardUser) {
        context.getEntityManager().merge(sfGuardUser);
    }

    public void remove(SfGuardUser sfGuardUser) {
        context.getEntityManager().remove(context.getEntityManager().merge(sfGuardUser));
    }

    public void removeOldInactiveUsers() {
        Date now = new Date();
        Calendar cal = new GregorianCalendar();
        cal.setTime(now);
        cal.add(Calendar.DATE, -30);
        context.getEntityManager().createQuery("delete from SfGuardUser u where u.createdAt < :time and u.isActive = 0")
                .setParameter("time", cal.getTime()).executeUpdate();
    }

    public SfGuardUser find(Object id) {
        return context.getEntityManager().find(SfGuardUser.class, id);
    }

    public SfGuardUser findByEmail(String email) {
        try {
            return (SfGuardUser) context.getEntityManager().createQuery("select object(u) from SfGuardUser u join u.sfGuardUserProfileCollection p where p.email = :email").setParameter("email", email)
                    .setMaxResults(1)
                    .getSingleResult();
        } catch (NoResultException ex) {
            return null;
        }
    }

    public SfGuardUser findByJabber(String jabber) {
        try {
            return (SfGuardUser) context.getEntityManager().createQuery("select object(u) from SfGuardUser u join u.sfGuardUserProfileCollection p where p.jabber = :jabber").setParameter("jabber", jabber)
                    .setMaxResults(1)
                    .getSingleResult();
        } catch (NoResultException ex) {
            return null;
        }
    }

    public SfGuardUser findByIcq(String icq) {
        try {
            return (SfGuardUser) context.getEntityManager().createQuery("select object(u) from SfGuardUser u join u.sfGuardUserProfileCollection p where p.icq = :icq").setParameter("icq", icq)
                    .setMaxResults(1)
                    .getSingleResult();
        } catch (NoResultException ex) {
            return null;
        }
    }

    public boolean isPresenceExists(SfGuardUser user, String presence) {
        List l = context.getEntityManager().createQuery("select object(p) from Post p join p.userId u where u.id = :user_id and p.text = :text and (p.type = :type1 or p.type = :type2)")
                .setMaxResults(1)
                .setParameter("user_id", user.getId())
                .setParameter("type1", "jabberStatus")
                .setParameter("type2", "icqStatus")
                .setParameter("text", presence).getResultList();
        return !l.isEmpty();
    }
}
