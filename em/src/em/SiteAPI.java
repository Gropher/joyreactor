/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package em;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.File;
import java.io.FileOutputStream;
import java.io.InputStream;
import java.net.URLEncoder;
import java.util.Date;
import java.util.logging.Level;
import java.util.logging.Logger;
import org.apache.commons.httpclient.HttpClient;
import org.apache.commons.httpclient.HttpStatus;
import org.apache.commons.httpclient.methods.GetMethod;
import org.apache.commons.httpclient.methods.PostMethod;
import org.apache.commons.httpclient.methods.multipart.FilePart;
import org.apache.commons.httpclient.methods.multipart.MultipartRequestEntity;

/**
 *
 * @author gropher
 */
public class SiteAPI {

    private final String UPLOAD_URL;
    private final String POST_INSERT_URL;
    private final String MAIN_PAGE_URL;
    private final String CROSSPOSTING_NAME;
    private final String CROSSPOSTING_PASS;
    private Context context;

    public SiteAPI(Context context) {
        this.context = context;
        this.UPLOAD_URL = this.context.SITE_URL + "/api/upload";
        this.POST_INSERT_URL = this.context.SITE_URL + "/api/postInsertTrigger";
        this.MAIN_PAGE_URL = this.context.SITE_URL + "/api/mainPageTrigger";
        this.CROSSPOSTING_NAME = this.context.CROSSPOSTING_NAME;
        this.CROSSPOSTING_PASS = this.context.CROSSPOSTING_PASS;
    }

    public Boolean postCreateTrigger(Post post) {
        try {
            HttpClient client = new HttpClient();
            GetMethod method = new GetMethod(POST_INSERT_URL+"/login/"+URLEncoder.encode(CROSSPOSTING_NAME, "UTF-8")+"/pass/"+URLEncoder.encode(CROSSPOSTING_PASS, "UTF-8")+"/post_id/"+post.getId().toString());
            Logger.getLogger(SiteAPI.class.getName()).log(Level.INFO, "{0}/login/{1}/pass/{2}/post_id/{3}", new Object[]{POST_INSERT_URL, URLEncoder.encode(CROSSPOSTING_NAME, "UTF-8"), URLEncoder.encode(CROSSPOSTING_PASS, "UTF-8"), post.getId().toString()});
            client.executeMethod(method);
        } catch (Exception ex) {
            Logger.getLogger(SiteAPI.class.getName()).log(Level.SEVERE, null, ex);
        }
        return true;
    }

    public Boolean mainPageTrigger(Post post) {
        try {
            HttpClient client = new HttpClient();
            GetMethod method = new GetMethod(MAIN_PAGE_URL+"/login/"+URLEncoder.encode(CROSSPOSTING_NAME, "UTF-8")+"/pass/"+URLEncoder.encode(CROSSPOSTING_PASS, "UTF-8")+"/post_id/"+post.getId().toString());
            Logger.getLogger(SiteAPI.class.getName()).log(Level.INFO, "{0}/login/{1}/pass/{2}/post_id/{3}", new Object[]{MAIN_PAGE_URL, URLEncoder.encode(CROSSPOSTING_NAME, "UTF-8"), URLEncoder.encode(CROSSPOSTING_PASS, "UTF-8"), post.getId().toString()});
            client.executeMethod(method);
        } catch (Exception ex) {
            Logger.getLogger(SiteAPI.class.getName()).log(Level.SEVERE, null, ex);
        }
        return true;
    }

    public String saveImageFile(String filename, InputStream input) {
        try {
            filename = (new Date()).getTime() + filename;
            File file = new File(filename);
            FileOutputStream fos = new FileOutputStream(file);
            BufferedOutputStream bos = new BufferedOutputStream(fos);
            BufferedInputStream bis = new BufferedInputStream(input);
            int aByte;
            while ((aByte = bis.read()) != -1) {
                bos.write(aByte);
            }
            bos.flush();
            bos.close();
            bis.close();

            HttpClient client = new HttpClient();
            PostMethod method = new PostMethod(UPLOAD_URL);
            org.apache.commons.httpclient.methods.multipart.Part[] parts = {
                new FilePart("file", file)
            };

            method.setRequestEntity(new MultipartRequestEntity(parts, method.getParams()));
            int statusCode = client.executeMethod(method);

            if (statusCode != HttpStatus.SC_OK) {
                return "";
            }
            byte[] responseBody = method.getResponseBody();
            file.delete();
            return new String(responseBody).trim();
        } catch (Exception ex) {
            Logger.getLogger(ReceivingTask.class.getName()).log(Level.SEVERE, null, ex);
            return "";
        }
    }
}
