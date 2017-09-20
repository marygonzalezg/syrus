<?php header("Content-type: text/css; charset: UTF-8"); ?>

* {
  border: 1px solid rgba(0, 0, 0, 0.2);
  padding=0;
  margin=0;
}

.grid{
  display:grid;
  grid-templates-columns: 1fr 1fr;
  grid-templates-rows: 1fr 1fr 1fr 1fr;
  grid-template-areas:
  "title title"
  "header header";
  <!--"sidebar sidebar"
  "sidebar content"
  "footer footer";-->
  grid-gap: 0px;
}

.title{
  grid-column-start:1;
  grid-column-end:3;
  align-self:centers;

}

.header{
  grid-column-start:1;
  grid-column-end:3;
  align-self:center;
}

.grid div:nth-child(even){
}

.grid div:nth-child(odd){
}

table {
  height: 0%;
  left: 0%;
  margin: 0px auto;
  position: static;
  width: 100%;
}

thead th {
  background: beige;
  color: black;
  font-family: 'Lato', sans-serif;
  font-size: 16px;
  font-weight: 100;
  letter-spacing: 2px;
  text-transform: uppercase;
}

tbody{
  background: beige;
  color: black;
  font-family: 'Lato', sans-serif;
  font-size: 16px;
  font-weight: 100;
  letter-spacing: 2px;
  text-transform: lowercase;
}

tr {
  background:#beige;
  border-bottom: 1px solid #FFF;
  margin-bottom: 5px;
  color: black;
  text-transform: capitalize;
}

td {
  font-family: 'Lato', sans-serif;
  font-size: 18px;
  font-weight: 400;
  color:black;
  padding: 10px;
  text-align: center;
  width: 25%;
}

body{
  background: AntiqueWhite;
  margin: 0;
  padding: 3% 5%;
}

#map{
  width:100%;
  height:480px;
  position: initial;
}

#marker{
  margin: 0;
  padding: 5%;
}

@media screen and (min-width: 736px){
  .grid{
    display:grid;
    grid-templates-columns: 1fr 1fr;
    grid-templates-rows: 1fr 1fr 1fr 1fr;
    grid-template-areas:
    "title title"
    "header header";
    <!--"sidebar sidebar"
    "sidebar content"
    "footer footer";-->
    grid-gap: 0px;
  }
}
