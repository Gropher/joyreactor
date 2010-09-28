/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package em;

import java.io.Serializable;
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
import javax.persistence.Table;
import javax.persistence.Temporal;
import javax.persistence.TemporalType;

/**
 *
 * @author gropher
 */
@Entity
@Table(name = "post_attribute")
@NamedQueries({@NamedQuery(name = "PostAttribute.findAll", query = "SELECT p FROM PostAttribute p"), @NamedQuery(name = "PostAttribute.findById", query = "SELECT p FROM PostAttribute p WHERE p.id = :id"), @NamedQuery(name = "PostAttribute.findByType", query = "SELECT p FROM PostAttribute p WHERE p.type = :type"), @NamedQuery(name = "PostAttribute.findByCreatedAt", query = "SELECT p FROM PostAttribute p WHERE p.createdAt = :createdAt"), @NamedQuery(name = "PostAttribute.findByUpdatedAt", query = "SELECT p FROM PostAttribute p WHERE p.updatedAt = :updatedAt")})
public class PostAttribute implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id")
    private Integer id;
    @Basic(optional = false)
    @Column(name = "type")
    private String type;
    @Basic(optional = false)
    @Lob
    @Column(name = "value")
    private String value;
    @Basic(optional = false)
    @Lob
    @Column(name = "origin")
    private String origin;
    @Lob
    @Column(name = "comment")
    private String comment;
    @Column(name = "created_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date createdAt = new Date();
    @Column(name = "updated_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date updatedAt = new Date();
    @JoinColumn(name = "post_id", referencedColumnName = "id")
    @ManyToOne(optional = false)
    private Post postId;

    public PostAttribute() {
    }

    public PostAttribute(Integer id) {
        this.id = id;
    }

    public PostAttribute(Integer id, String type, String value) {
        this.id = id;
        this.type = type;
        this.value = value;
    }

    public PostAttribute(Post postId, String type, String value) {
        this.postId = postId;
        this.type = type;
        this.value = value;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getValue() {
        return value;
    }

    public void setValue(String value) {
        this.value = value;
    }

    public String getComment() {
        return comment;
    }

    public void setComment(String comment) {
        this.comment = comment;
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

    public Post getPostId() {
        return postId;
    }

    public void setPostId(Post postId) {
        this.postId = postId;
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
        if (!(object instanceof PostAttribute)) {
            return false;
        }
        PostAttribute other = (PostAttribute) object;
        if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "ejb.PostAttribute[id=" + id + "]";
    }

}
