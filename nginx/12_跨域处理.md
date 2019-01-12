```
location / {
    if ($request_method = OPTIONS ) {
       add_header Access-Control-Allow-Origin *;
       add_header Access-Control-Allow-Methods "POST,GET,PUT,DELETE";
       add_header Access-Control-Max-Age "3600";
       add_header Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept, Authorization";
    	 add_header Access-Control-Allow-Credentials "true";
       add_header Content-Length 0;
       return 200;
  	}

    add_header 'Access-Control-Allow-Origin' *;
    add_header 'Access-Control-Allow-Credentials' 'true';
	  add_header 'Access-Control-Allow-Methods' 'GET,PUT,POST,DELETE';
    add_header 'Access-Control-Allow-Headers' 'Content-Type,*';
}

```
