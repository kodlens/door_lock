/*
 *  RFID Reader
*/

#define SS_PIN 2  //D4
#define RST_PIN 0 //D3

#include <ESP8266WiFi.h>
#include <SPI.h>
#include <MFRC522.h>


//const char* ssid="doorlock";   //Put your wifi network name here
//const char* password = "1234-1234";   //Put your wifi password here


const char* ssid="doorlock";   //Put your wifi network name here
const char* password = "1234-1234";   //Put your wifi password here

IPAddress local_ip(192,168,254,40);
IPAddress subnet(255,255,255,0);
IPAddress gateway(192,168,254,1);
IPAddress primaryDNS(8,8,8,8); //optional
IPAddress secondaryDNS(8,8,4,4); //optional

WiFiServer server(80);


MFRC522 mfrc522(SS_PIN, RST_PIN);   // Create MFRC522 instance.
int statuss = 0;
int out = 0;
String content= "";

void setup() 
{
  Serial.begin(9600);   // Initiate a serial communication
  delay(100);
  SPI.begin();      // Initiate  SPI bus
  mfrc522.PCD_Init();   // Initiate MFRC522

  Serial.println(" RIFD Sample Program");
  
  WiFi.begin(ssid,password);  
  
  server.begin();
  Serial.println("Server started");

  //configure static IP
  if(!WiFi.config(local_ip, gateway, subnet, primaryDNS, secondaryDNS)){
    Serial.println("STA failed to configure");
  }
  while( WiFi.status() != WL_CONNECTED ){  
    //while loop runs repeatedly unless condition is false
    //it'll keep trying unless wifi is connected      
    delay(500);      
    Serial.print("#.");          
  }
  Serial.println("Device IP Address: ");
  Serial.print(WiFi.localIP()); 
}


void loop() 
{
  delay(100);
  WiFiClient client = server.available();
  if (!client) 
  {
    return;
  }
  while(!client.available())
  {
    delay(1);
  }
  String request = client.readStringUntil('\r');
  client.flush();

  if (request.indexOf("/scan") != -1)  
  { 
    Serial.println("Scanning RFID");
    // Look for new cards
    if ( ! mfrc522.PICC_IsNewCardPresent()) 
    {
      return;
    }
    delay(100);
    
    // Select one of the cards
    if ( ! mfrc522.PICC_ReadCardSerial()) 
    {
      return;
    }
    delay(100);
    
    content = "";
    for (byte i = 0; i < mfrc522.uid.size; i++) 
    {
       //Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
       //Serial.print(mfrc522.uid.uidByte[i], HEX);
       content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? "0" : ""));
       content.concat(String(mfrc522.uid.uidByte[i], HEX));
    }

    delay(100);
    content.toUpperCase();

  }//end if


  // Return the response
  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/html");
  client.println("Access-Control-Allow-Origin: *");
  
  client.println(""); //  this is a must
  client.print(content);
  Serial.println(content);
  delay(1);
  
}//end loop 
