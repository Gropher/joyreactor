/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package em;

import java.io.Serializable;
import java.util.Collection;
import java.util.Date;
import javax.persistence.Basic;
import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.Lob;
import javax.persistence.ManyToOne;
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
@Table(name = "post_comment")
@NamedQueries({@NamedQuery(name = "PostComment.findAll", query = "SELECT p FROM PostComment p"), @NamedQuery(name = "PostComment.findById", query = "SELECT p FROM PostComment p WHERE p.id = :id"), @NamedQuery(name = "PostComment.findByPower", query = "SELECT p FROM PostComment p WHERE p.power = :power"), @NamedQuery(name = "PostComment.findByIsnew", query = "SELECT p FROM PostComment p WHERE p.isnew = :isnew"), @NamedQuery(name = "PostComment.findByCreatedAt", query = "SELECT p FROM PostComment p WHERE p.createdAt = :createdAt"), @NamedQuery(name = "PostComment.findByUpdatedAt", query = "SELECT p FROM PostComment p WHERE p.updatedAt = :updatedAt")})
public class PostComment implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id")
    private Integer id;
    @Basic(optional = false)
    @Lob
    @Column(name = "comment")
    private String comment;
    @Basic(optional = false)
    @Column(name = "power")
    private int power;
    @Column(name = "isnew")
    private Boolean isnew = true;
    @Column(name = "created_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date createdAt = new Date();
    @Column(name = "updated_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date updatedAt = new Date();
    @JoinColumn(name = "user_id", referencedColumnName = "id")
    @ManyToOne(optional = false)
    private SfGuardUser userId;
    @JoinColumn(name = "post_id", referencedColumnName = "id")
    @ManyToOne(optional = false)
    private Post postId;
    @OneToMany(mappedBy = "parentId")
    private Collection<PostComment> postCommentCollection;
    @JoinColumn(name = "parent_id", referencedColumnName = "id")
    @ManyToOne
    private PostComment parentId;

    public PostComment() {
    }

    public PostComment(Integer id) {
        this.id = id;
    }

    public PostComment(Integer id, String comment, int power) {
        this.id = id;
        this.comment = comment;
        this.power = power;
    }

    public PostComment(SfGuardUser userId, Post postId, String comment) {
        this.userId = userId;
        this.comment = comment;
        this.postId = postId;
    }

    public PostComment(SfGuardUser userId, Post postId, PostComment parentId, String comment) {
        this.userId = userId;
        this.comment = comment;
        this.postId = postId;
        this.parentId = parentId;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getComment() {
        return comment;
    }

    public void setComment(String comment) {
        this.comment = comment;
    }

    public int getPower() {
        return power;
    }

    public void setPower(int power) {
        this.power = power;
    }

    public Boolean getIsnew() {
        return isnew;
    }

    public void setIsnew(Boolean isnew) {
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

    public Post getPostId() {
        return postId;
    }

    public void setPostId(Post postId) {
        this.postId = postId;
    }

    public Collection<PostComment> getPostCommentCollection() {
        return postCommentCollection;
    }

    public void setPostCommentCollection(Collection<PostComment> postCommentCollection) {
        this.postCommentCollection = postCommentCollection;
    }

    public PostComment getParentId() {
        return parentId;
    }

    public void setParentId(PostComment parentId) {
        this.parentId = parentId;
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
        if (!(object instanceof PostComment)) {
            return false;
        }
        PostComment other = (PostComment) object;
        if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "ejb.PostComment[id=" + id + "]";
    }

}
