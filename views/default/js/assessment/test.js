/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define(function(require) {
    var elgg = require("elgg");
    var $ = require("jquery");


if (window.performance) {
  console.info("window.performance works fine on this browser");
}
console.info(performance.navigation.type);
if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
  //console.info( "This page is reloaded" );
  //history.back();
} else {
  //console.info( "This page is not reloaded");
}
}); 