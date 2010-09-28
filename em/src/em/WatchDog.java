/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package em;

import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author gropher
 */
public class WatchDog implements Runnable {

    private Context context;

    public WatchDog(Context context) {
        this.context = context;
    }

    public void run() {
        while (true) {
            try {
                doWork();
                Thread.sleep(20000);
            } catch (Exception ex) {
                Logger.getLogger(WatchDog.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    private void doWork() {
        if(context.USE_JABBER && !context.getMessaging().isJabberConnected()) {
            System.out.println("WatchDog: jabber down, restarting");
            context.getMessaging().restartJabber();
        }
        if(context.USE_ICQ && !context.getMessaging().isIcqConnected()) {
            System.out.println("WatchDog: icq down, restarting");
            context.getMessaging().restartIcq();
        }
    }

}
