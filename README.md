# Payment Api integration document. 
##### Framework: Symfony 6.4
#### php: 8.2  

Start to check it out
1. git clone git@github.com:julfiker/symfony6.git
2. docker-compose up
3. http://127.0.0.1:8000


## 1. Aci payment API
Resource: `post http://{host}/api/v1/payments/aci `   

Request Body 
```json
{  
    "amount": 50,  
    "currency": "EUR",  
    "cardNumber":"4200000000000000",  
    "cardExpYear":"2034",  
    "cardExpMonth": "05",  
    "cardCvv": "123"  
}
```
Response Body  
```json 
{  
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
}
```

## 1. Shift4 payment API  
Resource: 
`post http://{host}/api/v1/payments/shift4` 

Request Body 
```json
{  
    "amount": 50.00,  
    "currency": "USD",  
    "cardNumber":"tok_NGsyDoJQXop5Pqqi6HizbJTe",  
    "cardExpYear":"2034",  
    "cardExpMonth": "05",  
    "cardCvv": "123"  
}
```
Response Body  
```json 
{  
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
}
```
  
## Command
--m=aci|shift4  as required option.  
arg1 = amount  
arg2 = currency  
arg3 = cardNumber  
arg4 = cardExpYear  
arg5 = cardExpMonth  
arg6 = cardCvv
  
#### 1. Aci     
`php bin/console app:make-payment --m=aci 50 EUR 4200000000000000 2034 05 123`

#### 2. Shift4
`php bin/console app:make-payment --m=shift4 50 USD tok_NGsyDoJQXop5Pqqi6HizbJTe 2024 05 123`


Note:   
Made Simple docker image with the docker compose.  
I could not add test coverage at all due to time. In fact, I have a full time job.  
Payment method specific I used separate controller and services as well.     
If you want you can use single controller with multiple routes

Contact me on over the skype or whatsapp if you have any concern.   
whatsapp: +8801817108853  
skype: eng.jewel  

Thanks :)
 