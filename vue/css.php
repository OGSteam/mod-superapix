<?php
/**
 * @package [Mod] Superapix
 * @author Machine
 * @copyright Copyright &copy; 2016, http://ogsteam.fr/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
if (!defined('IN_SPYOGAME') || !defined('IN_SUPERAPIX'))
    die("Hacking attempt");
?>

<style>

    body{
        background-color: black;
    }
    h1 {
        font-size: 40px;
        color: white;
        text-align: left;
        margin-left: 10%;
        margin-right: 10%;

    }
    h2 {
        font-size: 25px;
        color: rgb(240, 240, 240 );
        text-align: left;
        margin-left: 10%;
        margin-right: 10%;
    }

    p {
        font-size: 15px;
        color: rgb(200, 200, 200 );
        text-align: left;
        margin-left: 5%;
        margin-right:  5%;
        margin-bottom: 5px;
        margin-top: 1px;

    }

    p.error, p.success{


        padding: 15px;
        margin-bottom: 5px;
        border: 1px solid transparent;
        border-radius: 4px;
        border-color : red;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        display: block;
    }
    p.error{
        color: #a94442;
        background-color:  rgba(215, 44, 44, 0.3);
        border-color: red;
    }
    p.success{
        color: #3c763d;
        background-color:  rgba(98, 146, 64, 0.3);
        border-color: green;
    }
    div.mod {
        background-color:  rgba(20, 20, 20, 0.9);
        margin:  20px;
        padding: 10px;
        display: block;
        border-radius: 8px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    div.error{
        color: #a94442;
        background-color:  rgba(215, 44, 44, 0.3);
        border-color: red;
    }
    
     div.error:hover {
        background-color:  rgba(215, 44, 44, 0.4);
    }


    div.success{
        color: #3c763d;
        background-color:  rgba(98, 146, 64, 0.3);
        border-color: green;
    }

    p.error:hover {
        background-color:  rgba(215, 44, 44, 0.4);
    }

    p.success:hover {
        background-color:  rgba(98, 146, 64, 0.4);
    }

    p.error:hover, p.success:hover {
        padding-left : 20px;
    }

    .mod ul {
        text-align: left;
        list-style-type: none;
        list-style:none; 
        margin-bottom: 6px;
        margin-left: 8%;
        margin-right: 8%;
        padding:10px 0; 
        color: rgb(180, 180, 180 );
    }

    .mod li {
        font:Helvetica, Verdana, sans-serif;
        color: rgb(200, 200, 200 );

    }

    .mod li:last-child {
        border: none;
    }

    .mod li a {
        text-decoration: none;
        color: rgb(200, 200, 200 );

        -webkit-transition: font-size 0.3s ease, background-color 0.3s ease;
        -moz-transition: font-size 0.3s ease, background-color 0.3s ease;
        -o-transition: font-size 0.3s ease, background-color 0.3s ease;
        -ms-transition: font-size 0.3s ease, background-color 0.3s ease;
        transition: font-size 0.3s ease, background-color 0.3s ease;
        display: block;
        width: 100%;
    }

    .mod li a:hover {
        font-size: 30px;
        color: white;
    }
    .btn {
        -webkit-border-radius: 28;
        -moz-border-radius: 28;
        border-radius: 28px;
        font-family: Arial;
        color: #5e5c5e;
        font-size: 20px;
        background: #f7f7f7;
        padding: 10px 20px 10px 20px;
        margin: 30px;
        margin-left: 20%;
        text-decoration: none;
        display: inline-block;      
    }

    .btn:hover {
        background: #777d80;
        color: white;
        background-image: -webkit-linear-gradient(top, #777d80, #3f4142);
        background-image: -moz-linear-gradient(top, #777d80, #3f4142);
        background-image: -ms-linear-gradient(top, #777d80, #3f4142);
        background-image: -o-linear-gradient(top, #777d80, #3f4142);
        background-image: linear-gradient(to bottom, #777d80, #3f4142);
        text-decoration: none;
    }

    *, *:before, *:after {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }


    form {
        max-width: 400px;
        margin: 10px auto;
        padding: 10px 20px;
        background: rgba(0,0,0,0.5);
        border-radius: 8px;
        color: white;
    }


    input[type="text"],
    select {
        background: rgba(255,255,255,0.1);
        border: none;
        font-size: 16px;
        height: auto;
        margin: 0;
        outline: 0;
        padding: 15px;
        width: 100%;
        background-color: #e8eeef;
        color: #8a97a0;
        box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
        margin-bottom: 30px;
    }

    input[type="radio"],
    input[type="checkbox"] {
        margin: 0 4px 8px 0;
    }

    select {
        padding: 6px;
        height: 32px;
        border-radius: 2px;
    }


    legend {
        font-size: 1.4em;
        margin-bottom: 10px;
    }

    label {
        display: block;
        margin-bottom: 8px;

    }





</style>



