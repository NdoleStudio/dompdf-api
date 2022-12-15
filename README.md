dompdf API
==========

[![Build](https://github.com/NdoleStudio/dompdf-api/actions/workflows/ci.yml/badge.svg)](https://github.com/NdoleStudio/dompdf-api/actions/workflows/ci.yml)
[![GitHub contributors](https://img.shields.io/github/contributors/NdoleStudio/dompdf-api)](https://github.com/NdoleStudio/dompdf-api/graphs/contributors)
[![GitHub license](https://img.shields.io/github/license/NdoleStudio/dompdf-api?color=brightgreen)](https://github.com/NdoleStudio/dompdf-api/blob/master/LICENSE)

This project provides an HTTP API wrapper around the [dompdf](https://github.com/dompdf/dompdf) library which converts HTML to PDF. The API is created
using the Laravel framework, and you can protect the API using the [basic HTTP authentication scheme](https://datatracker.ietf.org/doc/html/rfc7617).

## Docker Setup

Run the docker container using the command below 

```bash
docker run -p 8000:80 ndolestudio/dompdf-api
```

Make an HTTP request to convert an HTML string into a PDF

```bash
curl -X POST -d '<h1>Hello World</h1>' http://localhost:8000
```

## Authentication

If you want to protect the API with basic auth, you can set the `AUTH_USERNAME` and `AUTH_PASSWORD` enviornment variables when running the docker container

```bash
docker run -p 8000:80 --env APP_USERNAME="username" --env APP_PASSWORD="password" ndolestudio/dompdf-api
```

**NOTE:** You must now set the username and password when making requests to the API

```bash
## username:password in base64 is dXNlcm5hbWU6cGFzc3dvcmQ=
curl -X POST -d '<h1>Hello World</h1>' -H 'Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ=' http://localhost:8000
```


## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Acho Arnold via [arnold@ndolestudio.com](mailto:arnold@ndolestudio.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
