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
@Table(name = "message_attachment")
@NamedQueries({@NamedQuery(name = "MessageAttachment.findAll", query = "SELECT p FROM MessageAttachment p"), @NamedQuery(name = "MessageAttachment.findById", query = "SELECT p FROM MessageAttachment p WHERE p.id = :id"), @NamedQuery(name = "MessageAttachment.findByType", query = "SELECT p FROM MessageAttachment p WHERE p.type = :type"), @NamedQuery(name = "MessageAttachment.findByCreatedAt", query = "SELECT p FROM MessageAttachment p WHERE p.createdAt = :createdAt"), @NamedQuery(name = "MessageAttachment.findByUpdatedAt", query = "SELECT p FROM MessageAttachment p WHERE p.updatedAt = :updatedAt")})
public class MessageAttachment implements Serializable {
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
    @Lob
    @Column(name = "comment")
    private String comment;
    @Column(name = "created_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date createdAt = new Date();
    @Column(name = "updated_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date updatedAt = new Date();
    @JoinColumn(name = "message_id", referencedColumnName = "id")
    @ManyToOne(optional = false)
    private Message messageId;

    public MessageAttachment() {
    }

    public MessageAttachment(Integer id) {
        this.id = id;
    }

    public MessageAttachment(Integer id, String type, String value) {
        this.id = id;
        this.type = type;
        this.value = value;
    }

    public MessageAttachment(String type, String value) {
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

    public Message getMessageId() {
        return messageId;
    }

    public void setMessageId(Message messageId) {
        this.messageId = messageId;
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
        if (!(object instanceof MessageAttachment)) {
            return false;
        }
        MessageAttachment other = (MessageAttachment) object;
        if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "ejb.MessageAttachment[id=" + id + "]";
    }

}
