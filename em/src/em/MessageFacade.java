package em;

import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.List;

/**
 *
 * @author gropher
 */
public class MessageFacade {

    private Context context;

    public MessageFacade(Context context) {
        this.context = context;
    }

    public Message create(Message message) {
        context.getEntityManager().persist(message);
        context.getEntityManager().flush();
        return message;
    }

    public void createPostConfirm(Post post, String protocol, String address) {
        String text = "";
        if(post.getType().equalsIgnoreCase("jabberStatus")||post.getType().equalsIgnoreCase("icqStatus")) {
            return;
            //text += "Ваш новый статус уже на реакторе: "+context.SITE_URL+"/post/show/id/" + post.getId() + "\n";
        } else {
            text += "Принято! "+context.SITE_URL+"/post/" + post.getId() + "\n";
        }
        
        if (protocol.equalsIgnoreCase("smtp")) {
            text += "<br/>Вы можете ответить прямо из письма, если ваш почтовый клиент позволяет это: " + "<br/>\n" +
                    "<form target='_blank' action='"+context.SITE_URL+"/post_comment/create/post_id/" + post.getId() + "'>\n" +
                    "<input id='noajax' type='hidden' value='1' name='noajax'/>\n" +
                    "<textarea id='comment_text' cols='50' rows='5' name='comment_text'/><br/>\n" +
                    "<input id='submit' type='submit' value='Добавить' name='commit'/>\n" +
                    "</form>";
        } else {
            text += "Для добавления комментария используйте команду: @c|" + post.getId();
        }
        Message message = new Message(post.getUserId(), "outgoing", "confirm_post", protocol, "new", address, text, post.getId());
        context.getEntityManager().persist(message);
        context.getEntityManager().flush();
    }

    public void createCommentConfirm(PostComment comment, String protocol, String address) {
        String text = "Принято! "+context.SITE_URL+"/post/" + comment.getPostId().getId() + "#comment" + comment.getId() + "\n";
        if (protocol.equalsIgnoreCase("smtp")) {
            text += "<br/>Вы можете ответить прямо из письма, если ваш почтовый клиент позволяет это: " + "<br/>\n" +
                    "<form target='_blank' action='"+context.SITE_URL+"/post_comment/create/post_id/" + comment.getPostId().getId() + "'>\n" +
                    "<input id='noajax' type='hidden' value='1' name='noajax'/>\n" +
                    "<input id='parent_id' type='hidden' value='" + comment.getId() + "' name='parent_id'/>\n" +
                    "<textarea id='comment_text' cols='50' rows='5' name='comment_text'/><br/>\n" +
                    "<input id='submit' type='submit' value='Добавить' name='commit'/>\n" +
                    "</form>";
        } else {
            text += "Для ответа используйте команду: @c|" + comment.getPostId().getId() + "|" + comment.getId();
        }
        Message message = new Message(comment.getUserId(), "outgoing", "confirm_comment", protocol, "new", address, text, comment.getId());
        context.getEntityManager().persist(message);
        context.getEntityManager().flush();
    }

    public void createPostDeleteConfirm(Post post, String protocol, String address) {
        Message message = new Message(post.getUserId(), "outgoing", "confirm_post", protocol, "new", address,
                "Ваш пост под номером " + post.getId() + " удален.");
        context.getEntityManager().persist(message);
        context.getEntityManager().flush();
    }

    public void createCommentDeleteConfirm(PostComment comment, String protocol, String address) {
        Message message = new Message(comment.getUserId(), "outgoing", "confirm_comment", protocol, "new", address,
                "Ваш комментарий под номером " + comment.getId() + " удален.");
        context.getEntityManager().persist(message);
        context.getEntityManager().flush();
    }

    public void createHelp(SfGuardUser user, String protocol, String address) {
        String text;
        if (protocol.equalsIgnoreCase("smtp")) {
            text = "В настоящее время система рассылки сообщений сайта "+context.SITE_NAME+" поддерживает следующие команды:<br/>\n" +
                    "@p :) #<тег> <текст поста> - добавить пост, :) - настроение поста ( :) - нормальное, :D - отличное, :( - плохое), список тегом можно посмотреть на <a href='"+context.SITE_URL+"'>сайте</a>. Тег и настроение можно не указывать.<br/>\n" +
                    "@c|<номер поста> - добавить комментарий к посту, например: @c|123<br/>\n" +
                    "@c|<номер поста>|<номер комментария> - ответить на комменарий к посту, например: @c|123|54321<br/>\n" +
                    "@d|p|<номер поста> - удалить пост, например: @d|p|123<br/>\n" +
                    "@d|c|<номер комментария> - удалить комментарий, например: @d|c|54321<br/>\n" +
                    "@h - вывести этот список.";
        } else {
            text = "В настоящее время система рассылки сообщений сайта "+context.SITE_NAME+" поддерживает следующие команды:\n" +
                    "@p :) #<тег> <текст поста> - добавить пост, :) - настроение поста ( :) - нормальное, :D - отличное, :( - плохое), список тегом можно посмотреть на сайте ("+context.SITE_URL+"). Тег и настроение можно не указывать.\n" +
                    "@c|<номер поста> - добавить комментарий к посту, например: @c|123\n" +
                    "@c|<номер поста>|<номер комментария> - ответить на комменарий к посту, например: @c|123|54321\n" +
                    "@d|p|<номер поста> - удалить пост, например: @d|p|123\n" +
                    "@d|c|<номер комментария> - удалить комментарий, например: @d|c|54321\n" +
                    "@h - вывести этот список.";
        }
        Message message = new Message(user, "outgoing", "help", protocol, "new", address, text);
        context.getEntityManager().persist(message);
        context.getEntityManager().flush();
    }

    public void createCommandError(SfGuardUser user, String protocol, String address) {
        String text = "Такой команды нет. Отправьте @h для вывода списка доступных команд.";
        Message message = new Message(user, "outgoing", "error_notify", protocol, "new", address, text);
        context.getEntityManager().persist(message);
        context.getEntityManager().flush();
    }

    public void edit(Message message) {
        message.setUpdatedAt(new Date());
        context.getEntityManager().merge(message);
        context.getEntityManager().flush();
    }

    public void remove(Message message) {
        context.getEntityManager().remove(context.getEntityManager().merge(message));
    }

    public void removeOldMessages() {
        Date now = new Date();
        Calendar cal = new GregorianCalendar();
        cal.setTime(now);
        cal.add(Calendar.DATE, -30);
        context.getEntityManager().createQuery("delete from Message m where m.createdAt < :time").setParameter("time", cal.getTime()).executeUpdate();
    }

    public Message find(Object id) {
        return context.getEntityManager().find(Message.class, id);
    }

    public List<Message> findAll(int limit, String direction, String status, String protocol) {
        return context.getEntityManager().createQuery("select object(m) from Message as m where m.direction = :direction and m.status = :status and m.protocol = :protocol order by m.createdAt asc").setMaxResults(limit).setParameter("direction", direction).setParameter("status", status).setParameter("protocol", protocol).getResultList();
    }

    public List<Message> findAll(int limit, String direction, String status) {
        return context.getEntityManager().createQuery("select object(m) from Message as m where m.direction = :direction and m.status = :status order by m.createdAt asc").setMaxResults(limit).setParameter("direction", direction).setParameter("status", status).getResultList();
    }

    public Boolean isBounceMessage(Message message) {
        List res = context.getEntityManager().createQuery("select object(m) from Message as m where m.text = :text and m.direction = :direction and m.protocol = :protocol and m.status = :status and m.userId = :userId order by m.updatedAt desc").setMaxResults(1).setParameter("text", message.getText()).setParameter("protocol", message.getProtocol()).setParameter("direction", "outgoing").setParameter("status", "sent").setParameter("userId", message.getUserId()).getResultList();
        return !res.isEmpty() && (new Date()).getTime() - ((Message) res.get(0)).getUpdatedAt().getTime() < 360000;
    }
}
