/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


define(function(require) {
    var elgg = require("elgg");
    var $ = require("jquery");

//console.log('9fdf');
var max_fields = 10;
    var wrapper = $(".container1");
    var add_button = $(".add_form_field");

    var x = 1;
    $(add_button).click(function(e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            $(wrapper).append('<div style="padding-bottom: 18px;"><select name="mytext[]" value="1" style="float: left; margin-right:12px;"><option value="2"> </option><option value="1">Correct answer</option></select> <input type="text" name="mytext[]" style="display: inline-block; width: 75%; vertical-align: middle;"/><a href="#" class="delete" style="margin-left: 8px;">Delete</a></div>'); //add input box
        } else {
            alert('You Reached the limits')
        }
    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    })

   
});

