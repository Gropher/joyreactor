/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
package em;

import java.io.Serializable;
import java.util.Date;
import java.util.LinkedList;
import java.util.List;
import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;
import javax.persistence.NamedQueries;
import javax.persistence.NamedQuery;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;

/**
 *
 * @author gropher
 */
@Entity
@Table(name = "sf_guard_user_profile")
@NamedQueries({@NamedQuery(name = "SfGuardUserProfile.findAll", query = "SELECT s FROM SfGuardUserProfile s"), @NamedQuery(name = "SfGuardUserProfile.findById", query = "SELECT s FROM SfGuardUserProfile s WHERE s.id = :id"), @NamedQuery(name = "SfGuardUserProfile.findByEmail", query = "SELECT s FROM SfGuardUserProfile s WHERE s.email = :email"), @NamedQuery(name = "SfGuardUserProfile.findByFullname", query = "SELECT s FROM SfGuardUserProfile s WHERE s.fullname = :fullname"), @NamedQuery(name = "SfGuardUserProfile.findByIcq", query = "SELECT s FROM SfGuardUserProfile s WHERE s.icq = :icq"), @NamedQuery(name = "SfGuardUserProfile.findByJabber", query = "SELECT s FROM SfGuardUserProfile s WHERE s.jabber = :jabber"), @NamedQuery(name = "SfGuardUserProfile.findByLjlogin", query = "SELECT s FROM SfGuardUserProfile s WHERE s.ljlogin = :ljlogin"), @NamedQuery(name = "SfGuardUserProfile.findByLjpassword", query = "SELECT s FROM SfGuardUserProfile s WHERE s.ljpassword = :ljpassword"), @NamedQuery(name = "SfGuardUserProfile.findByAvatar", query = "SELECT s FROM SfGuardUserProfile s WHERE s.avatar = :avatar"), @NamedQuery(name = "SfGuardUserProfile.findByRating", query = "SELECT s FROM SfGuardUserProfile s WHERE s.rating = :rating"), @NamedQuery(name = "SfGuardUserProfile.findByValidate", query = "SELECT s FROM SfGuardUserProfile s WHERE s.validate = :validate"), @NamedQuery(name = "SfGuardUserProfile.findByIsnew", query = "SELECT s FROM SfGuardUserProfile s WHERE s.isnew = :isnew"), @NamedQuery(name = "SfGuardUserProfile.findByCreatedAt", query = "SELECT s FROM SfGuardUserProfile s WHERE s.createdAt = :createdAt"), @NamedQuery(name = "SfGuardUserProfile.findByUpdatedAt", query = "SELECT s FROM SfGuardUserProfile s WHERE s.updatedAt = :updatedAt")})
public class SfGuardUserProfile implements Serializable {

    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id")
    private Integer id;
    @Column(name = "email")
    private String email;
    @Column(name = "fullname")
    private String fullname;
    @Column(name = "icq")
    private String icq;
    @Column(name = "jabber")
    private String jabber;
    @Column(name = "commentsToJabber")
    private Boolean commentsToJabber;
    @Column(name = "commentsToIcq")
    private Boolean commentsToIcq;
    @Column(name = "commentsToMail")
    private Boolean commentsToMail;
    @Column(name = "useCrossposting")
    private Boolean useCrossposting;
    @Column(name = "collectJabberStatus")
    private Boolean collectJabberStatus;
    @Column(name = "collectIcqStatus")
    private Boolean collectIcqStatus;
    @Column(name = "notifyfriendline")
    private Boolean notifyFriendline;
    @Column(name = "ljlogin")
    private String ljlogin;
    @Column(name = "ljpassword")
    private String ljpassword;
    @Column(name = "avatar")
    private String avatar;
    @Basic(optional = false)
    @Column(name = "rating")
    private double rating;
    @Column(name = "validate")
    private String validate;
    @Column(name = "isnew")
    private Short isnew = 1;
    @Column(name = "created_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date createdAt = new Date();
    @Column(name = "updated_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date updatedAt = new Date();
    @JoinColumn(name = "user_id", referencedColumnName = "id")
    @ManyToOne(optional = false)
    private SfGuardUser userId;

    public SfGuardUserProfile() {
    }

    public SfGuardUserProfile(Integer id) {
        this.id = id;
    }

    public SfGuardUserProfile(Integer id, double rating) {
        this.id = id;
        this.rating = rating;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getFullname() {
        return fullname;
    }

    public void setFullname(String fullname) {
        this.fullname = fullname;
    }

    public String getIcq() {
        return icq;
    }

    public void setIcq(String icq) {
        this.icq = icq;
    }

    public String getJabber() {
        return jabber;
    }

    public void setJabber(String jabber) {
        this.jabber = jabber;
    }

    public Boolean getCommentsToJabber() {
        return commentsToJabber;
    }

    public void setCommentsToJabber(Boolean commentsToJabber) {
        this.commentsToJabber = commentsToJabber;
    }

    public Boolean getCollectIcqStatus() {
        return collectIcqStatus;
    }

    public void setCollectIcqStatus(Boolean collectIcqStatus) {
        this.collectIcqStatus = collectIcqStatus;
    }

    public Boolean getCommentsToIcq() {
        return commentsToIcq;
    }

    public void setCommentsToIcq(Boolean commentsToIcq) {
        this.commentsToIcq = commentsToIcq;
    }

    public List<String> getCommentsProtocols() {
        LinkedList<String> res = new LinkedList<String>();
        if (commentsToJabber) {
            res.add("xmpp");
        }
        if (commentsToIcq) {
            res.add("icq");
        }
        if (commentsToMail) {
            res.add("smtp");
        }
        return res;
    }

    public Boolean getCommentsToMail() {
        return commentsToMail;
    }

    public void setCommentsToMail(Boolean commentsToMail) {
        this.commentsToMail = commentsToMail;
    }

    public Boolean getUseCrossposting() {
        return useCrossposting;
    }

    public void setUseCrossposting(Boolean useCrossposting) {
        this.useCrossposting = useCrossposting;
    }

    public Boolean getCollectJabberStatus() {
        return collectJabberStatus;
    }

    public void setCollectJabberStatus(Boolean collectJabberStatus) {
        this.collectJabberStatus = collectJabberStatus;
    }

    public Boolean getNotifyFriendline() {
        return notifyFriendline;
    }

    public void setNotifyFriendline(Boolean notifyFriendline) {
        this.notifyFriendline = notifyFriendline;
    }

    public String getLjlogin() {
        return ljlogin;
    }

    public void setLjlogin(String ljlogin) {
        this.ljlogin = ljlogin;
    }

    public String getLjpassword() {
        return ljpassword;
    }

    public void setLjpassword(String ljpassword) {
        this.ljpassword = ljpassword;
    }

    public String getAvatar() {
        return avatar;
    }

    public void setAvatar(String avatar) {
        this.avatar = avatar;
    }

    public double getRating() {
        return rating;
    }

    public void setRating(double rating) {
        this.rating = rating;
    }

    public String getValidate() {
        return validate;
    }

    public void setValidate(String validate) {
        this.validate = validate;
    }

    public Short getIsnew() {
        return isnew;
    }

    public void setIsnew(Short isnew) {
        this.isnew = isnew;
    }

    public Date getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(Date createdAt) {
        this.createdAt = createdAt;
    }

    public Date getUpdatedAt() {
        return updatedAt;
    }

    public void setUpdatedAt(Date updatedAt) {
        this.updatedAt = updatedAt;
    }

    public SfGuardUser getUserId() {
        return userId;
    }

    public void setUserId(SfGuardUser userId) {
        this.userId = userId;
    }

    @Override
    public int hashCode() {
        int hash = 0;
        hash += (id != null ? id.hashCode() : 0);
        return hash;
    }

    @Override
    public boolean equals(Object object) {
        // TODO: Warning - this method won't work in the case the id fields are not set
        if (!(object instanceof SfGuardUserProfile)) {
            return false;
        }
        SfGuardUserProfile other = (SfGuardUserProfile) object;
        if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "ejb.SfGuardUserProfile[id=" + id + "]";
    }
}
