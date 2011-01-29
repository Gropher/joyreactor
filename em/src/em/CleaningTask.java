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
public class CleaningTask implements Runnable {

    private Context context;

    public CleaningTask(Context context) {
        this.context = context;
    }

    @SuppressWarnings("SleepWhileHoldingLock")
    public void run() {
        while (true) {
            try {
                doWork();
                Thread.sleep(3600000);
            } catch (Exception ex) {
                Logger.getLogger(WatchDog.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    private void doWork() {
        if (context.beginTransaction()) {
            System.out.println("Cleaning: start");
            try {
                context.getMessageFacade().removeOldMessages();
                context.getSfGuardUserFacade().removeOldInactiveUsers();
            } catch (Exception ex) {
                Logger.getLogger(WatchDog.class.getName()).log(Level.SEVERE, null, ex);
            }
            context.commitTransaction();
            System.out.println("Cleaning: end");
        } else {
            System.out.println("Cleaning: WAIT");
        }
    }

}
