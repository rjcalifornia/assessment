/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define(function(require) {
    var elgg = require("elgg");
    var $ = require("jquery");
var sec = document.getElementById('container_guid_details').value;
var time = setInterval(myTimer, 1000);
var referer = document.referrer;


function myTimer() {
    
    var minutes = Math.floor((sec/60));
    if(sec >= 60){
        
    
    document.getElementById('timer').innerHTML = "Remaining time: "+ minutes + " minutes";
}
    else{
        document.getElementById('timer').innerHTML = "Remaining time: "+minutes + " minutes and "+ sec + " seconds left";
    }
   // console.log(sec);
    
    sec--;
    if (sec == -1) {
        clearInterval(time);
        alert("Time out. You have exceded the maximum time limit");
        window.location.href = referer;
    }
}
});