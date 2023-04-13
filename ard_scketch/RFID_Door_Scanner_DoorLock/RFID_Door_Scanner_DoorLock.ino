/*
 *  Created by TheCircuit
*/
#define MOTORPIN 16 //D0
#define SS_PIN 2  //D4
#define RST_PIN 0 //D3

#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <Servo.h>
#include <SPI.h>
#include <MFRC522.h>


Servo servo;


//here are the credentials to fill out before loading to microcontroller
const char* ssid="annateah";   //Put your wifi network name here
const char* password = "11223344";   //Put your wifi password here
String content= "";
String serverName = "http://192.168.0.10/rfid"; //server/host address
String doorId = "1"; //door id, must be same from database or should i use ip or mac



IPAddress local_ip(192,168,0,46);
IPAddress subnet(255,255,255,0);
IPAddress gateway(192,168,0,1);
IPAddress primaryDNS(8,8,8,8); //optional
IPAddress secondaryDNS(8,8,4,4); //optional

WiFiServer server(80);


MFRC522 mfrc522(SS_PIN, RST_PIN);   // Create MFRC522 instance.
int statuss = 0;
int out = 0;


void setup() 
{
  Serial.begin(9600);   // Initiate a serial communication
  delay(100);
  SPI.begin();      // Initiate  SPI bus
  delay(100);
  mfrc522.PCD_Init();   // Initiate MFRC522
  
  delay(100);
  servo.attach(MOTORPIN);
  servo.write(0); //Moving servo to 0 degree
  delay(300);
  servo.detach();

  Serial.println(" RIFD With Servo Program");
  
  WiFi.begin(ssid,password);  
  
  server.begin();
  delay(300);
  
  Serial.println("Server started. Connecting to WIFI.");

  //configure static IP
  if(!WiFi.config(local_ip, gateway, subnet, primaryDNS, secondaryDNS)){
    Serial.println("STA failed to configure");
  }
  while( WiFi.status() != WL_CONNECTED ){  
    //while loop runs repeatedly unless condition is false
    //it'll keep trying unless wifi is connected      
    delay(500);      
    Serial.print(".");          
  }
  Serial.println("Connected. \nDevice IP Address: ");
  Serial.print(WiFi.localIP()); 
}


void loop() 
{
  delay(500);


  // Look for new cards
  if ( ! mfrc522.PICC_IsNewCardPresent()) 
  {
    return;
  }
  // Select one of the cards
  if ( ! mfrc522.PICC_ReadCardSerial()) 
  {
    return;
  }
  //Show UID on serial monitor
  Serial.println();
  Serial.print("UID tag :");
  String content= "";
  byte letter;
  for (byte i = 0; i < mfrc522.uid.size; i++) 
  {
     Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");
     Serial.print(mfrc522.uid.uidByte[i], HEX);
     content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? "0" : ""));
     content.concat(String(mfrc522.uid.uidByte[i], HEX));
  }
  content.toUpperCase();
  Serial.println();
  
  if(WiFi.status()== WL_CONNECTED){
    
    HTTPClient http;
    WiFiClient client;
    String serverPath = serverName + "?rfid=" + content + "&doormac=" + WiFi.macAddress();

    http.begin(client, serverPath.c_str());
    int httpResponseCode = http.GET();
  
    if (httpResponseCode > 0) {
      Serial.println("Request url: " + serverPath);
      Serial.print("HTTP Response code: ");
      Serial.println(httpResponseCode);
      String payload = http.getString();
      Serial.println("Http response: " + payload);

      if(payload == "1"){
        servo.attach(MOTORPIN);
        servo.write(180);
        delay(80);
        servo.detach();
    
        delay(2000); //delay until change state to lock
    
        servo.attach(MOTORPIN);
        servo.write(0); //Moving servo to 0 degree
        delay(300);
        servo.detach();
      }
    }
    else {
      Serial.print("Error code: ");
      Serial.println(httpResponseCode);
    }
    // Free resources
    http.end();
    
  }else{
    Serial.println("WiFi Disconnected");
  }
  
  
//  if (content == "EAA20181") //change UID of the card that you want to give access
//  {
//    servo.attach(MOTORPIN);
//    servo.write(180);
//    delay(80);
//    servo.detach();
//
//    delay(2000);
//
//    servo.attach(MOTORPIN);
//    servo.write(0); //Moving servo to 0 degree
//    delay(300);
//    servo.detach();
//  }
//  
//  else   {
//    Serial.println(" Access Denied ");
//    delay(3000);
//  }

}//end loop 
