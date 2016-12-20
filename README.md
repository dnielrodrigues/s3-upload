## S3 uploads diretamente do browser:

Police do tipo site:

```
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Sid": "AddPerm",
            "Effect": "Allow",
            "Principal": {
                "AWS": "arn:aws:iam::321321321321321:user/IAM" 
            },
            "Action": "s3:*",
            "Resource": "arn:aws:s3:::bucket"
        }
    ]
}
```

...
