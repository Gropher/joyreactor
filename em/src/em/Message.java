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
@Table(name = "message")
@NamedQueries({@NamedQuery(name = "Message.findAll", query = "SELECT m FROM Message m"), @NamedQuery(name = "Message.findById", query = "SELECT m FROM Message m WHERE m.id = :id"), @NamedQuery(name = "Message.findByObjectId", query = "SELECT m FROM Message m WHERE m.objectId = :objectId"), @NamedQuery(name = "Message.findByDirection", query = "SELECT m FROM Message m WHERE m.direction = :direction"), @NamedQuery(name = "Message.findByType", query = "SELECT m FROM Message m WHERE m.type = :type"), @NamedQuery(name = "Message.findByProtocol", query = "SELECT m FROM Message m WHERE m.protocol = :protocol"), @NamedQuery(name = "Message.findByStatus", query = "SELECT m FROM Message m WHERE m.status = :status"), @NamedQuery(name = "Message.findByCreatedAt", query = "SELECT m FROM Message m WHERE m.createdAt = :createdAt"), @NamedQuery(name = "Message.findByUpdatedAt", query = "SELECT m FROM Message m WHERE m.updatedAt = :updatedAt")})
public class Message implements Serializable {
    private static final long serialVersionUID = 1L;
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Basic(optional = false)
    @Column(name = "id")
    private Integer id;
    @Column(name = "object_id")
    private Integer objectId;
    @Basic(optional = false)
    @Column(name = "direction")
    private String direction;
    @Basic(optional = false)
    @Column(name = "type")
    private String type;
    @Basic(optional = false)
    @Column(name = "protocol")
    private String protocol;
    @Basic(optional = false)
    @Column(name = "status")
    private String status;
    @Basic(optional = false)
    @Column(name = "address")
    private String address;
    @Lob
    @Column(name = "text")
    private String text = "";
    @Column(name = "created_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date createdAt = new Date();
    @Column(name = "updated_at")
    @Temporal(TemporalType.TIMESTAMP)
    private Date updatedAt = new Date();
    @JoinColumn(name = "user_id", referencedColumnName = "id")
    @ManyToOne(optional = false)
    private SfGuardUser userId;
    @OneToMany(cascade = CascadeType.ALL, mappedBy = "messageId")
    private Collection<MessageAttachment> messageAttachmentCollection;

    public Message() {
    }

    public Message(Integer id) {
        this.id = id;
    }

    public Message(SfGuardUser user, String direction, String type, String protocol, String status, String address, String text) {
        this.userId = user;
        this.direction = direction;
        this.type = type;
        this.protocol = protocol;
        this.status = status;
        this.address = address;
        if(text == null)
            this.text = "";
        else
            this.text = text.trim();
        this.objectId = 0;
    }

    public Message(SfGuardUser user, String direction, String type, String protocol, String status, String address, String text, Integer objectId) {
        this.userId = user;
        this.direction = direction;
        this.type = type;
        this.protocol = protocol;
        this.status = status;
        this.address = address;
        this.text = text.trim();
        if(text == null)
            this.text = "";
        else
            this.text = text.trim();
        this.objectId = objectId;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getObjectId() {
        return objectId;
    }

    public void setObjectId(Integer objectId) {
        this.objectId = objectId;
    }

    public String getDirection() {
        return direction;
    }

    public void setDirection(String direction) {
        this.direction = direction;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getProtocol() {
        return protocol;
    }

    public void setProtocol(String protocol) {
        this.protocol = protocol;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getText() {
        return text;
    }

    public void setText(String text) {
        this.text = text.trim();
    }

    public String getEmail(){
        return this.address;
    }

    public String getJabber(){
        return this.address;
    }

    public String getIcq(){
        return this.address;
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

    public Collection<MessageAttachment> getMessageAttachmentCollection() {
        return messageAttachmentCollection;
    }

    public void setMessageAttachmentCollection(Collection<MessageAttachment> messageAttachmentCollection) {
        this.messageAttachmentCollection = messageAttachmentCollection;
    }

    public String getReplyProtocol(){
        if(protocol.equalsIgnoreCase("pop"))
            return "smtp";
        else if(protocol.equalsIgnoreCase("xmpp"))
            return "xmpp";
        else if(protocol.equalsIgnoreCase("icq"))
            return "icq";
        else
            return "unsupported";
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
        if (!(object instanceof Message)) {
            return false;
        }
        Message other = (Message) object;
        if ((this.id == null && other.id != null) || (this.id != null && !this.id.equals(other.id))) {
            return false;
        }
        return true;
    }

    @Override
    public String toString() {
        return "ejb.Message[id=" + id + "]";
    }

}
