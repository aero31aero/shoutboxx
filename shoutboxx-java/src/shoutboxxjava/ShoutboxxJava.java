/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package shoutboxxjava;

import com.restfb.*;
import com.restfb.types.Post;
import java.sql.DriverManager;
import java.sql.Statement;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

/**
 *
 * @author rohitt
 */
public class ShoutboxxJava {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        try{
            System.out.println("code came here");
            
            Class.forName("com.mysql.jdbc.Driver");    
            java.sql.Connection con=DriverManager.getConnection("jdbc:mysql://localhost:3306/shoutboxx","root","root");
            Statement stmt=con.createStatement();
            System.out.println("Database Connected");
            String query;
            
            FacebookClient fbclient= new DefaultFacebookClient("CAACEdEose0cBAKoKjHuM84ZCx8FaDTfPigGSGCo2xzVbtDkOxvj5UUEYs7ZC1mm8paSXaV7W8rAanHqWbiYmyE9ea1hCnwTGryDQaDEy3X5TUPjxgVmmZAWgDbaKTSYimYdoBcCsTLZAdBDkCJpqd610zZApqtmiZAAj1KXBktge89Wf8yVc8s2q3FfYwvshlKlgf5V12xbgZDZD");
            com.restfb.Connection<Post> pageFeed = fbclient.fetchConnection("268071286573583/feed", Post.class);
            System.out.println("code comes here");
            for (List<Post> myFeedConnectionPage : pageFeed){            
                for (Post post : myFeedConnectionPage){
                    String msg=post.getMessage();
                    query="INSERT INTO posts VALUES(\""+post.getId()+"\",\""+msg+"\");";                    
                    System.out.println(query);
                    int executeUpdate = stmt.executeUpdate(query);
                    System.out.println("Update result: "+ executeUpdate+"\n");
                
                }
            }
            System.out.println("code comes here as well");
        }
        catch(Exception e){
            System.out.println("Error found: "+e.getMessage()+"\n"+e.getClass().getName());
            
        }
    }
    
    public static String getOnlyStrings(String s) {
    Pattern pattern = Pattern.compile("[^a-z A-Z]");
    Matcher matcher = pattern.matcher(s);
    String number = matcher.replaceAll("");
    return number;
 }
}
