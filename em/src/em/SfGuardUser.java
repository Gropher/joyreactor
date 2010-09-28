/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package em;

import java.io.Serializable;
import java.util.Collection;
import java.util.Date;
import javax.persistence.Basic;
import javax.persistence.CascadeType;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.NamedQueries;
import javax.persistence.NamedQuery;
import javax.persistence.OneToMany;
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;

/**
 *
 * @author gropher
 */
@Entity
@Table(name = "sf_guard_user")
@NamedQueries({@NamedQuery(name = "SfGuardUser.findAll", query = "SELECT s FROM SfGuardUser s"), @NamedQuery(name = "SfGuardUser.findById", query = "SELECT s FROM SfGuardUser s WHERE s.id = :id"), @NamedQuery(name = "SfGuardUser.findByUsername", query = "SELECT s FROM SfGuardUser s WHERE s.username = :username"), @NamedQuery(name = "SfGuardUser.findByAlgorithm", query = "SELECT s FROM SfGuardUser s WHERE s.algorithm = :algorithm"), @NamedQuery(name = "SfGuardUser.findBySalt", query = "SELECT s FROM SfGuardUser s WHERE s.salt = :salt"), @NamedQuery(name = "SfGuardUser.findByPassword", query = "SELECT s FROM SfGuardUser s WHERE s.password = :password"), @NamedQuery(name = "SfGuardUser.findByIsActive", query = "SELECT s FROM SfGuardUser s WHERE s.isActive = :isActive"), @NamedQuery(name = "SfGuardUser.findByIsSuperAdmin", query = "SELECT s FROM SfGuardUser s WHERE s.isSuperAdmin = :isSuperAdmin"), @NamedQuery(name = "SfGuardUser.findByLastLogin", query = "SELECT s FROM SfGuardUser s WHERE s.lastLogin = :lastLogin"), @NamedQuery(name = "SfGuardUser.findByCreatedAt", query = "SELECT s FROM SfGuardUser s WHERE s.createdAt = :createdAt"), @NamedQuery(name = "SfGuardUser.findByUpdatedAt", query = "SELECT s FROM SfGuardUser s WHERE s.updatedAt = :updatedAt")})
public class SfGuardUser implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id")
    private Integer id;
    @Basic(optional = false)
    @Column(name = "username")
    private String username;
    @Basic(optional = false)
    @Column(name = "algorithm")
    private String algorithm;
    @Column(name = "salt")
    private String salt;
    @Column(name = "password")
    private String password;
    @Column(name = "is_active")
    private Boolean isActive = false;
    @Column(name = "is_super_admin")
    private Boolean isSuperAdmin = false;
    @Column(name = "last_login")
    @Temporal(TemporalType.TIMESTAMP)
    private Date lastLogin;
    @Column(name = "created_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date createdAt = new Date();
    @Column(name = "updated_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date updatedAt = new Date();
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "userId")
    private Collection<Message> messageCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "userId")
    private Collection<Post> postCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "userId")
    private Collection<Hidden> hiddenCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "userId")
    private Collection<PostComment> postCommentCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "userId")
    private Collection<PostVote> postVoteCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "userId")
    private Collection<SfGuardUserProfile> sfGuardUserProfileCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "userId")
    private Collection<Blog> blogCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "userId")
    private Collection<Favorite> favoriteCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "userId")
    private Collection<Friend> friendCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "friendId")
    private Collection<Friend> friendCollection1;

    public SfGuardUser() {
    }

    public SfGuardUser(Integer id) {
        this.id = id;
    }

    public SfGuardUser(Integer id, String username, String algorithm) {
        this.id = id;
        this.username = username;
        this.algorithm = algorithm;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getAlgorithm() {
        return algorithm;
    }

    public void setAlgorithm(String algorithm) {
        this.algorithm = algorithm;
    }

    public String getSalt() {
        return salt;
    }

    public void setSalt(String salt) {
        this.salt = salt;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public Boolean getIsActive() {
        return isActive;
    }

    public void setIsActive(Boolean isActive) {
        this.isActive = isActive;
    }

    public Boolean getIsSuperAdmin() {
        return isSuperAdmin;
    }

    public void setIsSuperAdmin(Boolean isSuperAdmin) {
        this.isSuperAdmin = isSuperAdmin;
    }

    public Date getLastLogin() {
        return lastLogin;
    }

    public void setLastLogin(Date lastLogin) {
        this.lastLogin = lastLogin;
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

    public SfGuardUserProfile getProfile(){
        if(getSfGuardUserProfileCollection().size() == 0)
            return null;
        else
        {
            SfGuardUserProfile[] res = new SfGuardUserProfile[0];
            res = getSfGuardUserProfileCollection().toArray(res);
            Context.instance.getEntityManager().refresh(res[0]);
            return res[0];
        }
    }

    public String getAddress(String protocol){
        SfGuardUserProfile profile = this.getProfile();
        if (protocol.equalsIgnoreCase("smtp")) {
            return profile.getEmail();
        } else if (protocol.equalsIgnoreCase("xmpp") || protocol.equalsIgnoreCase("icq")) {
            return profile.getJabber();
        } else if (protocol.equalsIgnoreCase("icq")) {
            return profile.getIcq();
        } else {
            throw new UnsupportedOperationException("Unsupported protocol");
        }
    }

    public Collection<Message> getMessageCollection() {
        return messageCollection;
    }

    public void setMessageCollection(Collection<Message> messageCollection) {
        this.messageCollection = messageCollection;
    }

    public Collection<Post> getPostCollection() {
        return postCollection;
    }

    public void setPostCollection(Collection<Post> postCollection) {
        this.postCollection = postCollection;
    }

    public Collection<Hidden> getHiddenCollection() {
        return hiddenCollection;
    }

    public void setHiddenCollection(Collection<Hidden> hiddenCollection) {
        this.hiddenCollection = hiddenCollection;
    }

    public Collection<PostComment> getPostCommentCollection() {
        return postCommentCollection;
    }

    public void setPostCommentCollection(Collection<PostComment> postCommentCollection) {
        this.postCommentCollection = postCommentCollection;
    }

    public Collection<PostVote> getPostVoteCollection() {
        return postVoteCollection;
    }

    public void setPostVoteCollection(Collection<PostVote> postVoteCollection) {
        this.postVoteCollection = postVoteCollection;
    }

    public Collection<SfGuardUserProfile> getSfGuardUserProfileCollection() {
        return sfGuardUserProfileCollection;
    }

    public void setSfGuardUserProfileCollection(Collection<SfGuardUserProfile> sfGuardUserProfileCollection) {
        this.sfGuardUserProfileCollection = sfGuardUserProfileCollection;
    }

    public Collection<Blog> getBlogCollection() {
        return blogCollection;
    }

    public void setBlogCollection(Collection<Blog> blogCollection) {
        this.blogCollection = blogCollection;
    }

    public Collection<Favorite> getFavoriteCollection() {
        return favoriteCollection;
    }

    public void setFavoriteCollection(Collection<Favorite> favoriteCollection) {
        this.favoriteCollection = favoriteCollection;
    }

    public Collection<Friend> getFriendCollection() {
        return friendCollection;
    }

    public void setFriendCollection(Collection<Friend> friendCollection) {
        this.friendCollection = friendCollection;
    }

    public Collection<Friend> getFriendCollection1() {
        return friendCollection1;
    }

    public void setFriendCollection1(Collection<Friend> friendCollection1) {
        this.friendCollection1 = friendCollection1;
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
        if (!(object instanceof SfGuardUser)) {
            return false;
        }
        SfGuardUser other = (SfGuardUser) object;
        if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "ejb.SfGuardUser[id=" + id + "]";
    }

}
