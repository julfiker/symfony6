

//Use it for Shift4
curl -X POST http://symfony.rest/api/v1/payments/shift4 \
    -d "amount=499" \
    -d "currency=USD" \
    -d "customerId=cust_AoR0wvgntQWRUYMdZNLYMz5R" \
    -d "card=tok_NGsyDoJQXop5Pqqi6HizbJTe" \
    -d "description=Example charge"


//Aci payment api request body  
post {url}/api/v1/payments/aci  
Request Body     
`{  
    "amount": 50,  
    "currency": "EUR",  
    "cardNumber":"4200000000000000",  
    "cardExpYear":"2034",  
    "cardExpMonth": "05",  
    "cardCvv": "123"  
}`

Response Body  
`{  
    "transactionId": "8ac7a49f905d1b76019064d8e63a29d7",  
    "createdAt": "2024-06-29 16:34:14.860+0000",  
    "amount": "50.00",  
    "currency": "EUR",  
    "cardBin": {  
        "bin": "420000",  
        "last4Digits": "0000",  
        "holder": "Jane Jones",  
        "expiryMonth": "05",  
        "expiryYear": "2034"  
    }  
}`
  
#command   
`php bin/console app:make-payment --m=aci 50 USD 313131 2024 05 123`   
`php bin/console app:make-payment --m=shift4 50 USD 313131 2024 05 123`   