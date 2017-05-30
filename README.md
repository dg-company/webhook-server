# Webhook Server

A simple PHP server to trigger shell scripts via web hooks

## Running

docker run -v ~/webhooks:/var/www/html/config -p 80:80 doriangray/webhook-server

## Adding a webhook

1) Create a config file named `job-name.json`

2) Set a (random) token and which scripts should be called:

	{
	    "token": "d7s09f8sd9f8s09f7sd09f8sd09f70sd89f8sdsdfsdf",
	    "scripts": [
	        "whoami",
	        "echo $1 $2"
	    ]
	}

3) Call the trigger URL: `http://yourdomain.com/job-name/d7s09f8sd9f8s09f7sd09f8sd09f70sd89f8sdsdfsdf`

4) Optionally add parameters to your URL: `http://yourdomain.com/job-name/d7s09f8sd9f8s09f7sd09f8sd09f70sd89f8sdsdfsdf/hello/JD` (Accessible using $1, $2, ...)