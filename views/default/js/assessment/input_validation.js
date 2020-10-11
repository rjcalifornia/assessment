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

new AutoNumeric('#assessment_quantity', 
    {   decimalPlaces:'0', 
        digitGroupSeparator : '',
        maximumValue: "999",
        minimumValue: "1"});

new AutoNumeric('#assessment_duration', 
    {   decimalPlaces:'0', 
        digitGroupSeparator : '',
        maximumValue: "250", 
        minimumValue: "1"});

new AutoNumeric('#assessment_minimun_grade', 
    {   decimalPlaces:'0', 
        digitGroupSeparator : '',
        maximumValue: "100",    
        suffixText: AutoNumeric.options.suffixText.percentage,
        minimumValue: "1"});

 

   
});

