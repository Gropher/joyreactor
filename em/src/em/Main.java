package em;

/**
 *
 * @author gropher
 */
public class Main {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws InterruptedException {
        Context context = new Context();
        context.getMessaging().startMessaging();

        Thread sendThread = new Thread(new SendingTask(context), "Sending");
        sendThread.start();
        Thread.sleep(300);

        Thread receiveThread = new Thread(new ReceivingTask(context), "Receiving");
        receiveThread.start();
        Thread.sleep(300);

        Thread transiteThread = new Thread(new TransitionTask(context), "Transition");
        transiteThread.start();
        Thread.sleep(300);

        Thread watchDogThread = new Thread(new WatchDog(context), "WatchDog");
        watchDogThread.start();
        Thread.sleep(300);

        Thread cleanThread = new Thread(new CleaningTask(context), "Cleaning");
        cleanThread.start();
    }
}
