package em;

import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author gropher
 */
public class TransitionTask implements Runnable {

    private Context context;

    public TransitionTask(Context context) {
        this.context = context;
    }

    public void run() {
        while (true) {
            try {
                doWork();
                Thread.sleep(1000);
            } catch (Exception ex) {
                Logger.getLogger(SendingTask.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    public void doWork() {
        if (context.beginTransaction()) {
            System.out.println("Transition: start");
            try {
                transferMessages();
            } catch (Exception ex) {
                context.rollbackTransaction();
                System.out.println("Transition: rollback transaction");
                Logger.getLogger(TransitionTask.class.getName()).log(Level.SEVERE, null, ex);
            }
            context.commitTransaction();
            System.out.println("Transition: end");
        } else {
            System.out.println("Transition: WAIT");
        }
    }

    private void transferMessages() {
        for (Message m : context.getMessageFacade().findAll(10, "incoming", "new")) {
            processMessage(m);
        }
        for (PostComment c : context.getPostCommentFacade().findAll(10, true)) {
            commentToMessage(c);
        }
        for (Post p : context.getPostFacade().findAll(10, true)) {
            postToMessage(p);
        }
        for (Post p : context.getPostFacade().findAllCrossposting(10)) {
            context.getSiteApi().mainPageTrigger(p);
        }
    }

    private void processMessage(Message message) {
        if (message.getType().equalsIgnoreCase("unknown")) {
            message.setType("command");
            context.getMessageFacade().edit(message);
            processCommand(message);
        } else {
            messageToPost(message);
        }
    }

    private void processCommand(Message message) {
        String text = message.getText().trim();
        try {
            if (text.startsWith("@post") || text.startsWith("@p")) {
                message.setType("post");
                String[] parts = text.split("[ \n]");
                message.setText(text.substring(parts[0].length()).trim());
                context.getMessageFacade().edit(message);
                messageToPost(message);
            } else if (text.startsWith("@comment:") || text.startsWith("@c|")) {
                String[] parts = text.split("[ \n]");
                text = text.substring(parts[0].length()).trim();
                parts = parts[0].split("[:|]");
                PostComment comment = null;
                if (parts.length == 2) {
                    Post post = context.getPostFacade().find(Integer.parseInt(parts[1]));
                    comment = new PostComment(message.getUserId(), post, text);
                } else if (parts.length == 3) {
                    Post post = context.getPostFacade().find(Integer.parseInt(parts[1]));
                    PostComment parent = context.getPostCommentFacade().find(Integer.parseInt(parts[2]));
                    comment = new PostComment(message.getUserId(), post, parent, text);
                } else {
                    throw new Exception("Syntax error in command");
                }
                context.getPostCommentFacade().create(comment);
                context.getMessageFacade().createCommentConfirm(comment, message.getReplyProtocol(), message.getAddress());
                message.setStatus("processed");
                message.setType("post_comment");
                context.getMessageFacade().edit(message);
            } else if (text.startsWith("@delete:post:") || text.startsWith("@d|p|")) {
                String[] parts = text.split("[ \n]");
                text = text.substring(parts[0].length()).trim();
                parts = parts[0].split("[:|]");
                Post post = context.getPostFacade().find(Integer.parseInt(parts[2]));
                if (post.getUserId().getId() == message.getUserId().getId()) {
                    context.getMessageFacade().createPostDeleteConfirm(post, message.getProtocol(), message.getAddress());
                    context.getPostFacade().remove(post);
                }
            } else if (text.startsWith("@delete:comment:") || text.startsWith("@d|c|")) {
                String[] parts = text.split("[ \n]");
                text = text.substring(parts[0].length()).trim();
                parts = parts[0].split("[:|]");
                PostComment comment = context.getPostCommentFacade().find(Integer.parseInt(parts[2]));
                if (comment.getUserId().getId() == message.getUserId().getId()) {
                    context.getMessageFacade().createCommentDeleteConfirm(comment, message.getProtocol(), message.getAddress());
                    context.getPostCommentFacade().remove(comment);
                }
            } else if (text.startsWith("@list") || text.startsWith("@help") || text.startsWith("@l") || text.startsWith("@h")) {
                context.getMessageFacade().createHelp(message.getUserId(), message.getReplyProtocol(), message.getAddress());
            } else if (text.startsWith("@whoami")) {
                context.getMessageFacade().createWhoAmI(message.getUserId(), message.getReplyProtocol(), message.getAddress());
            } else {
                throw new Exception("Syntax error in command");
            }
            message.setStatus("processed");
        } catch (Exception ex) {
            message.setStatus("error");
            context.getMessageFacade().createCommandError(message.getUserId(), message.getReplyProtocol(), message.getAddress());
        }
        context.getMessageFacade().edit(message);
    }

    private void messageToPost(Message message) {
        String text = message.getText().trim();
        List<Blog> blogs = new ArrayList<Blog>();
        double moodNo = 0;
        boolean doWork = false;
        do {
            doWork = false;
            if (text.startsWith(":D")) {
                moodNo = 1;
                text = text.substring(2).trim();
                doWork = true;
            }
            if (text.startsWith(":(")) {
                moodNo = -1;
                text = text.substring(2).trim();
                doWork = true;
            }
            if (text.startsWith(":)")) {
                moodNo = 0;
                text = text.substring(2).trim();
                doWork = true;
            }
            if (text.startsWith("#") || text.startsWith("*")) {
                String[] parts = text.split("[,;:|\n]");
                Blog blog = context.getBlogFacade().findByTagOrCreate(parts[0].substring(1), message.getUserId());
                if (blog != null) {
                    text = text.substring(parts[0].length() + 1).trim();
                    blogs.add(blog);
                    doWork = true;
                }
            }
        } while (doWork);
        if(text.equalsIgnoreCase(""))
            return;
        Post post = new Post(message.getUserId(), text, moodNo, message.getType());
        post = context.getPostFacade().create(post);
        for (Blog blog : blogs) {
            BlogPost bp = new BlogPost();
            bp.setBlogId(blog);
            bp.setPostId(post);
            context.getBlogPostFacade().create(bp);
        }
        context.getEntityManager().flush();
        for (MessageAttachment a : message.getMessageAttachmentCollection()) {
            PostAttribute attr = new PostAttribute(post, a.getType(), a.getValue());
            context.getPostAttributeFacade().create(attr);
        }
        message.setStatus("processed");
        message.setObjectId(post.getId());
        context.getMessageFacade().edit(message);
        context.getMessageFacade().createPostConfirm(post, message.getReplyProtocol(), message.getAddress());
        System.out.println("Transition: post created, id: " + post.getId());
    }

    private void postToMessage(Post post) {
        for (Friend f : post.getUserId().getFriendCollection1()) {
            if(f.getUserId() != null) {
                SfGuardUserProfile profile = f.getUserId().getProfile();
                if (profile.getNotifyFriendline()) {
                    List<String> protocols = profile.getCommentsProtocols();
                    for (String protocol : protocols) {
                        Message message = new Message(f.getUserId(), "outgoing", "post_comment", protocol, "new", f.getUserId().getAddress(protocol), getPostMessageText(post, protocol), post.getId());
                        context.getMessageFacade().create(message);
                    }
                }
            }
        }
        post.setIsnew(false);
        context.getPostFacade().edit(post);
        System.out.println("Transition: post processed, id: " + post.getId());
    }

    private void commentToMessage(PostComment comment) {
        if (comment.getPostId() != null && comment.getUserId() != null) {
            if (comment.getUserId().getId() != comment.getPostId().getUserId().getId()) {
                SfGuardUserProfile profile = comment.getPostId().getUserId().getProfile();
                List<String> protocols = profile.getCommentsProtocols();
                for (String protocol : protocols) {
                    Message message = new Message(comment.getPostId().getUserId(), "outgoing", "post_comment", protocol, "new", comment.getPostId().getUserId().getAddress(protocol), getCommentMessageText(comment, true, protocol), comment.getId());
                    context.getMessageFacade().create(message);
                }
            }
            if (comment.getParentId() != null && comment.getPostId().getUserId().getId() != comment.getParentId().getUserId().getId()) {
                SfGuardUserProfile profile = comment.getParentId().getUserId().getProfile();
                List<String> protocols = profile.getCommentsProtocols();
                for (String protocol : protocols) {
                    Message message = new Message(comment.getParentId().getUserId(), "outgoing", "post_comment", protocol, "new", comment.getParentId().getUserId().getAddress(protocol), getCommentMessageText(comment, false, protocol), comment.getId());
                    context.getMessageFacade().create(message);
                }
            }
        }
        comment.setIsnew(false);
        context.getPostCommentFacade().edit(comment);
        System.out.println("Transition: comment processed, id: " + comment.getId());
    }

    private String getPostMessageText(Post post, String protocol) {
        if (protocol.equalsIgnoreCase("smtp")) {
            String res = "Ваш друг, пользователь <a href='" + context.SITE_URL + "/user/" + post.getUserId().getUsername() + "'>" + post.getUserId().getUsername() + "</a>" +
                         ", создал новый <a href='" + context.SITE_URL + "/post/" + post.getId() + "'>пост №" + post.getId() + "</a><br/>\n";
            res += "Настроение: " + post.getMoodName() + "<br/>\n";
            if(!post.getTagLine().equalsIgnoreCase(""))
                res += "Теги: " + post.getTagLine() + "<br/>\n";
            if(!post.getText().equalsIgnoreCase(""))
                res += "Текст поста: " + post.getText() + "<br/>\n";
            for(PostAttribute attr : post.getPostAttributeCollection())
                res += "<img src='"+context.SITE_URL+attr.getValue()+"'/><br/>\n";
            res += "Вы можете ответить прямо из письма, если ваш почтовый клиент позволяет это: " + "<br/>\n" +
                   "<form target='_blank' action='" + context.SITE_URL + "/post_comment/create/post_id/" + post.getId() + "'>\n" +
                   "<input id='noajax' type='hidden' value='1' name='noajax'/>\n" +
                   "<textarea id='comment_text' cols='50' rows='5' name='comment_text'/><br/>\n" +
                   "<input id='submit' type='submit' value='Добавить' name='commit'/>&nbsp;\n" +
                   "<a href='" + context.SITE_URL + "/post_vote/create/vote/plus/noajax/1/post_id/" + post.getId() + "'>Голосовать за</a>&nbsp;\n" +
                   "<a href='" + context.SITE_URL + "/post_vote/create/vote/minus/noajax/1/post_id/" + post.getId() + "'>Голосовать против</a>\n" +
                   "</form>";
            return res;
        } else if (protocol.equalsIgnoreCase("xmpp") || protocol.equalsIgnoreCase("icq")) {
            String res = "Ваш друг, пользователь " + post.getUserId().getUsername() +
                         ", создал новый пост №" + post.getId() + "\n";
            res += "Настроение: " + post.getMoodName() + "\n";
            if(!post.getTagLine().equalsIgnoreCase(""))
                res += "Теги: " + post.getTagLine() + "\n";
            if(!post.getText().equalsIgnoreCase(""))
                res += "Текст поста: " + post.getText() + "\n";
            res += context.SITE_URL + "/post/" + post.getId() + "\n" +
                   "Для добавления комментария используйте команду: @c|" + post.getId();
            return res;
        } else {
            throw new UnsupportedOperationException("Unsupported protocol");
        }
    }

    private String getCommentMessageText(PostComment comment, Boolean postAuthor, String protocol) {
        if (protocol.equalsIgnoreCase("smtp")) {
            return getCommentMailMessageText(comment, postAuthor);
        } else if (protocol.equalsIgnoreCase("xmpp") || protocol.equalsIgnoreCase("icq")) {
            return getCommentJabberMessageText(comment, postAuthor);
        } else {
            throw new UnsupportedOperationException("Unsupported protocol");
        }
    }

    private String getCommentJabberMessageText(PostComment comment, Boolean postAuthor) {
        String res = "";
        if (comment.getParentId() == null) {
            res = "К Вашему посту №" + comment.getPostId().getId() + " " + context.SITE_URL + "/post/" + comment.getPostId().getId() + " добавили комментарий:\n";
            res += "Настроение: " + comment.getPostId().getMoodName() + "\n";
            if(!comment.getPostId().getTagLine().equalsIgnoreCase(""))
                res += "Теги: " + comment.getPostId().getTagLine() + "\n";
            if(!comment.getPostId().getText().equalsIgnoreCase(""))
                res += "Текст: " + comment.getPostId().getText() + "\n";
            res += comment.getUserId().getUsername() + ": " + comment.getComment() + "\n" +
                   "Для ответа используйте команду: @c|" + comment.getPostId().getId() + "|" + comment.getId();
        } else {
            if (!postAuthor) {
                res = "Пришел ответ на Ваш комментарий к посту №" + comment.getPostId().getId() + " " + context.SITE_URL + "/post/" + comment.getPostId().getId() + "\n";
                res += "Настроение: " + comment.getPostId().getMoodName() + "\n";
                if(!comment.getPostId().getTagLine().equalsIgnoreCase(""))
                    res += "Теги: " + comment.getPostId().getTagLine() + "\n";
                if(!comment.getPostId().getText().equalsIgnoreCase(""))
                    res += "Текст: " + comment.getPostId().getText() + "\n";
                res += comment.getParentId().getUserId().getUsername() + ": " + comment.getParentId().getComment() + "\n" +
                       comment.getUserId().getUsername() + ": " + comment.getComment() + "\n" +
                       "Для ответа используйте команду: @c|" + comment.getPostId().getId() + "|" + comment.getId();
            } else {
                res = "Пришел ответ на один из комментариев к Вашему посту №" + comment.getPostId().getId() + " " + context.SITE_URL + "/post/" + comment.getPostId().getId() + "\n";
                res += "Настроение: " + comment.getPostId().getMoodName() + "\n";
                if(!comment.getPostId().getTagLine().equalsIgnoreCase(""))
                    res += "Теги: " + comment.getPostId().getTagLine() + "\n";
                if(!comment.getPostId().getText().equalsIgnoreCase(""))
                    res += "Текст: " + comment.getPostId().getText() + "\n";
                res += comment.getParentId().getUserId().getUsername() + ": " + comment.getParentId().getComment() + "\n" +
                       comment.getUserId().getUsername() + ": " + comment.getComment() + "\n" +
                       "Для ответа используйте команду: @c|" + comment.getPostId().getId() + "|" + comment.getId();
            }
        }
        return res;
    }

    private String getCommentMailMessageText(PostComment comment, Boolean postAuthor) {
        String res = "";
        if (comment.getParentId() == null) {
            res = "К Вашему <a href='" + context.SITE_URL + "/post/" + comment.getPostId().getId() +
                    "'>посту №" + comment.getPostId().getId() + "</a> добавили комментарий:<br/>\n";
            res += "Настроение: " + comment.getPostId().getMoodName() + "<br/>\n";
            if(!comment.getPostId().getTagLine().equalsIgnoreCase(""))
                res += "Теги: " + comment.getPostId().getTagLine() + "<br/>\n";
            if(!comment.getPostId().getText().equalsIgnoreCase(""))
                res += "Текст: " + comment.getPostId().getText() + "<br/>\n";
            for(PostAttribute attr : comment.getPostId().getPostAttributeCollection())
                res += "<img src='"+context.SITE_URL+attr.getValue()+"'/><br/>\n";
            res += "<a href='" + context.SITE_URL + "/user/" + comment.getUserId().getUsername() + "'>" +
                   comment.getUserId().getUsername() + "</a>: " + comment.getComment() + "<br/>\n" +
                   "Вы можете ответить прямо из письма, если ваш почтовый клиент позволяет это: " + "<br/>\n" +
                   "<form target='_blank' action='" + context.SITE_URL + "/post_comment/create/post_id/" + comment.getPostId().getId() + "'>\n" +
                   "<input id='noajax' type='hidden' value='1' name='noajax'/>\n" +
                   "<input id='parent_id' type='hidden' value='" + comment.getId() + "' name='parent_id'/>\n" +
                   "<textarea id='comment_text' cols='50' rows='5' name='comment_text'/><br/>\n" +
                   "<input id='submit' type='submit' value='Добавить' name='commit'/>\n" +
                   "</form>";
        } else {
            if (!postAuthor) {
                res = "Пришел ответ на Ваш комментарий к <a href='" + context.SITE_URL + "/post/" + comment.getPostId().getId() + "'>посту №" + comment.getPostId().getId() + "</a>:<br/>\n";
                res += "Настроение: " + comment.getPostId().getMoodName() + "<br/>\n";
                if(!comment.getPostId().getTagLine().equalsIgnoreCase(""))
                    res += "Теги: " + comment.getPostId().getTagLine() + "<br/>\n";
                if(!comment.getPostId().getText().equalsIgnoreCase(""))
                    res += "Текст: " + comment.getPostId().getText() + "<br/>\n";
                for(PostAttribute attr : comment.getPostId().getPostAttributeCollection())
                    res += "<img src='"+context.SITE_URL+attr.getValue()+"'/><br/>\n";
                res += "<a href='http://joyreactor.ru/user/" + comment.getParentId().getUserId().getUsername() + "'>" +
                       comment.getParentId().getUserId().getUsername() + "</a>: " + comment.getParentId().getComment() +
                       "<br/><a href='" + context.SITE_URL + "/user/" + comment.getUserId().getUsername() + "'>" +
                       comment.getUserId().getUsername() + "</a>: " + comment.getComment() + "<br/>\n" +
                       "Вы можете ответить прямо из письма, если ваш почтовый клиент позволяет это: " + "<br/>\n" +
                       "<form target='_blank' action='" + context.SITE_URL + "/post_comment/create/post_id/" + comment.getPostId().getId() + "'>\n" +
                       "<input id='noajax' type='hidden' value='1' name='noajax'/>\n" +
                       "<input id='parent_id' type='hidden' value='" + comment.getId() + "' name='parent_id'/>\n" +
                       "<textarea id='comment_text' cols='50' rows='5' name='comment_text'/><br/>\n" +
                       "<input id='submit' type='submit' value='Добавить' name='commit'/>\n" +
                       "</form>";
            } else {
                res = "Пришел ответ на один из комментариев к Вашему <a href='" + context.SITE_URL + "/post/" + comment.getPostId().getId() + "'>посту №" + comment.getPostId().getId() + "</a>:<br/>\n";
                res += "Настроение: " + comment.getPostId().getMoodName() + "<br/>\n";
                if(!comment.getPostId().getTagLine().equalsIgnoreCase(""))
                    res += "Теги: " + comment.getPostId().getTagLine() + "<br/>\n";
                if(!comment.getPostId().getText().equalsIgnoreCase(""))
                    res += "Текст: " + comment.getPostId().getText() + "<br/>\n";
                for(PostAttribute attr : comment.getPostId().getPostAttributeCollection())
                    res += "<img src='"+context.SITE_URL+attr.getValue()+"'/><br/>\n";
                res += "<a href='http://joyreactor.ru/user/" + comment.getParentId().getUserId().getUsername() + "'>" +
                       comment.getParentId().getUserId().getUsername() + "</a>: " + comment.getParentId().getComment() +
                       "<br/><a href='" + context.SITE_URL + "/user/" + comment.getUserId().getUsername() + "'>" +
                       comment.getUserId().getUsername() + "</a>: " + comment.getComment() + "<br/>\n" +
                       "Вы можете ответить прямо из письма, если ваш почтовый клиент позволяет это: " + "<br/>\n" +
                       "<form target='_blank' action='" + context.SITE_URL + "/post_comment/create/post_id/" + comment.getPostId().getId() + "'>\n" +
                       "<input id='noajax' type='hidden' value='1' name='noajax'/>\n" +
                       "<input id='parent_id' type='hidden' value='" + comment.getId() + "' name='parent_id'/>\n" +
                       "<textarea id='comment_text' cols='50' rows='5' name='comment_text'/><br/>\n" +
                       "<input id='submit' type='submit' value='Добавить' name='commit'/>\n" +
                       "</form>";
            }
        }
        return res;
    }
}
