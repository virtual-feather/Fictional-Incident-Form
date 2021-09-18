<?php
    header("Content-type: text/css; charset: UTF-8");
?>

/* table */
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  border: 2px solid black;
}

td {
  text-align: center;
  vertical-align: baseline;
  padding: 10px 5px 10px 0;
  border: 1px solid black;
}

th {
  text-align: center;
  vertical-align: middle;
  padding: 5px;
}

tr:hover {
    background-color: #f5f5f5;
}

td:hover, th:hover {
    background-color: #e0e0e0;
    color: darkcyan;
}

/* Form */
fieldset {
  /* centers form */
  margin: auto;
  display: table;
  padding: 10px 10px 10px 10px;
  border: 1px solid #ccc;
  color: #666;
  font-weight: bold;
  text-align: center;
}

fieldset legend {
  font-size: 17px;
  font-weight: 600;
    padding: 10px 5px 10px 5px;
}

/* Inputs */
.text-box {
  width: 100%;
  height: 10%;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

textarea {
    resize: none;
    padding-left: 10px;
}

.textarea-box {
  width: 100%;
  height: 50px;
  border: 1px solid #ccc;
}

input {
  box-sizing: border-box;
}

input[type=text]:focus, textarea:focus {
  border: 3px solid #ccc;
  -webkit-transition: 0.5s;
  transition: 0.5s;
  outline: none;
}

input[placeholder] {
    padding-left: 10px;
}

select {
  font-size: 15px;
  font-weight: 500;
}

/* Divs */
div {
    padding: 10px 10px 10px 10px;
}

.divContainer {
  display: table;
  margin: 10px auto;
}

.divRow {
  display: table-row;
    padding: 10px 10px 10px 10px;
}

.divTopLeft, .divTopRight,.divPeopleLeft, .divPeopleRight {
    display:inline-table;
    padding: 10px 10px 10px 10px;

}

.divPeopleBottom, .divIPAddressBottom, .divBottom {
    margin-right: 10px;
}

/* submit button */
input.submit {
  /* makes the submit button transparent */
  border: none;
  background-color: transparent;
  display: block;
  width: 200px;
  height: 200px;
  position: absolute;
}