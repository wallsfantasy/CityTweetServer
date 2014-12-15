# City Tweet Server

Server side for City Tweet project

### Features

  - Rest API with documentation brought to you by [NelmioApiDocBundle] (try GET /api/doc)
  - Result caching with MySQL and Memcached (by mistake.. -.-")
  - Independent services for caching, geocoder, history, and twitter. All with interfaces for loose coupling.
  - Many more to explore!!

Download now!! Get free api exposed GET /api/location for pure Google Geocoding API experience!!

### Route Exposed
```sh
GET /api/doc
GET /api/tweets
GET /api/histories
GET /api/locations
```

[NelmioApiDocBundle]: https://github.com/nelmio/NelmioApiDocBundle