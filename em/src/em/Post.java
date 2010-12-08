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
@Table(name = "post")
@NamedQueries({@NamedQuery(name = "Post.findAll", query = "SELECT p FROM Post p"), @NamedQuery(name = "Post.findById", query = "SELECT p FROM Post p WHERE p.id = :id"), @NamedQuery(name = "Post.findByRating", query = "SELECT p FROM Post p WHERE p.rating = :rating"), @NamedQuery(name = "Post.findByCommentsCount", query = "SELECT p FROM Post p WHERE p.commentsCount = :commentsCount"), @NamedQuery(name = "Post.findByMood", query = "SELECT p FROM Post p WHERE p.mood = :mood"), @NamedQuery(name = "Post.findByType", query = "SELECT p FROM Post p WHERE p.type = :type"), @NamedQuery(name = "Post.findByIsnew", query = "SELECT p FROM Post p WHERE p.isnew = :isnew"), @NamedQuery(name = "Post.findByCreatedAt", query = "SELECT p FROM Post p WHERE p.createdAt = :createdAt"), @NamedQuery(name = "Post.findByUpdatedAt", query = "SELECT p FROM Post p WHERE p.updatedAt = :updatedAt")})
public class Post implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id")
    private Integer id;
    @Basic(optional = false)
    @Lob
    @Column(name = "text")
    private String text = "";
    @Basic(optional = false)
    @Column(name = "rating")
    private double rating = 0.0;
    @Basic(optional = false)
    @Column(name = "comments_count")
    private int commentsCount = 0;
    @Column(name = "mood")
    private Double mood = 0.0;
    @Column(name = "type")
    private String type;
    @Column(name = "isnew")
    private Boolean isnew = true;
    @Column(name = "lj")
    private Boolean lj = false;
    @Basic(optional = false)
    @Column(name = "created_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date createdAt = new Date();
    @Basic(optional = false)
    @Column(name = "updated_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date updatedAt = new Date();
    @JoinColumn(name = "user_id", referencedColumnName = "id")
    @ManyToOne(optional = false)
    private SfGuardUser userId;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "postId")
    private Collection<PostComment> postCommentCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "postId")
    private Collection<PostVote> postVoteCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "postId")
    private Collection<PostAttribute> postAttributeCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "postId")
    private Collection<Favorite> favoriteCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "postId")
    private Collection<BlogPost> blogPostCollection;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "postId")
    private Collection<Hidden> hiddenCollection;

    public Post() {
    }

    public Post(Integer id) {
        this.id = id;
    }

    public Post(SfGuardUser user, String text, double mood, String type) {
        this.userId = user;
        this.text = text;
        this.mood = mood;
        this.type = type;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getText() {
        return text;
    }

    public void setText(String text) {
        this.text = text;
    }

    public double getRating() {
        return rating;
    }

    public void setRating(double rating) {
        this.rating = rating;
    }

    public int getCommentsCount() {
        return commentsCount;
    }

    public void setCommentsCount(int commentsCount) {
        this.commentsCount = commentsCount;
    }

    public Double getMood() {
        return mood;
    }

    public void setMood(Double mood) {
        this.mood = mood;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public Boolean getIsnew() {
        return isnew;
    }

    public void setIsnew(Boolean isnew) {
        this.isnew = isnew;
    }

    public Boolean getLj() {
        return lj;
    }

    public void setLj(Boolean lj) {
        this.lj = lj;
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

    public Collection<BlogPost> getBlogPostCollection() {
        return blogPostCollection;
    }

    public void setBlogPostCollection(Collection<BlogPost> blogPostCollection) {
        this.blogPostCollection = blogPostCollection;
    }

    public Collection<Favorite> getFavoriteCollection() {
        return favoriteCollection;
    }

    public void setFavoriteCollection(Collection<Favorite> favoriteCollection) {
        this.favoriteCollection = favoriteCollection;
    }

    public Collection<Hidden> getHiddenCollection() {
        return hiddenCollection;
    }

    public void setHiddenCollection(Collection<Hidden> hiddenCollection) {
        this.hiddenCollection = hiddenCollection;
    }

    public Collection<PostAttribute> getPostAttributeCollection() {
        return postAttributeCollection;
    }

    public void setPostAttributeCollection(Collection<PostAttribute> postAttributeCollection) {
        this.postAttributeCollection = postAttributeCollection;
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

    public String getTagLine() {
        String tagline = "";
        for(BlogPost blog : blogPostCollection) {
            tagline += "#" + blog.getBlogId().getTag() + " ";
        }
        return tagline;
    }

    public String getMoodName() {
        switch((int)Math.round(getMood())) {
            case 1:
                return "Отличное";
            case -1:
                return "Плохое";
            default:
                return "Нормальное";
        }
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
        if (!(object instanceof Post)) {
            return false;
        }
        Post other = (Post) object;
        if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "ejb.Post[id=" + id + "]";
    }

}
