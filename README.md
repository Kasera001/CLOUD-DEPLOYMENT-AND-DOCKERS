\# Cloud Deployment and Dockers



A small Node.js web app packaged in a Docker container, built while learning

containerisation and cloud deployment.



\## Contents



\- `MY DOCKER/`: the app and its Docker setup

&#x20; - `server.js`: the web server

&#x20; - `index.html`: the page it serves

&#x20; - `package.json`: Node.js dependencies and scripts

&#x20; - `dockerfile`: instructions for building the image

&#x20; - `.dockerignore`: files Docker should leave out of the image



\## Requirements



\- \[Docker](https://www.docker.com/) installed and running



\## How to run it



From inside the `MY DOCKER` folder:



```bash

docker build -t my-docker .

docker run -p 8080:8080 my-docker

```



Then open http://localhost:8080 in your browser.



\## What I learned



\- How a Dockerfile describes an image

\- How to build an image and run it as a container

\- How to publish a container port to my machine

