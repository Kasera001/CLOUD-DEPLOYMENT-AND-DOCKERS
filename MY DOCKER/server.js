// server on how the web server will operate

'use strict';
const express = require('express');
const path = require('path');
const publicpath = path.join(__dirname,'../app');
 // constant
 const PORT = 8080;
 const HOST = '0.0.0.0';

 //APP
 const app = express();
 app.use(express.static(publicpath));
 app.get('/', (req, res) => {
res.sendFile(path.join(publicpath, "index.html"));
})

//open comunication with the server
app.listen(PORT, HOST, () => {
    console.log(`Server is running on http://${HOST}:${PORT}`);
});