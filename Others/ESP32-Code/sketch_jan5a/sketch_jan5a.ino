#include <WiFi.h>
#include <HTTPClient.h>
#include <ESP32Servo.h>
#include <ArduinoJson.h>

/* WiFi */
const char* ssid = "your_wifi_name";
const char* password = "your_wifi_password";

/* API */
const char* apiUrl  = "your_api";
const char* passkey = "your_api_password";   // must match backend

/* Servo */
Servo servo;
#define SERVO_PIN 13

void setup() {
  Serial.begin(115200);

  servo.attach(SERVO_PIN);
  servo.write(0);   // locked by default

  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("\nWiFi Connected");
}

void loop() {

  if (WiFi.status() == WL_CONNECTED) {

    HTTPClient http;
    http.begin(apiUrl);
    http.addHeader("Content-Type", "application/json");

    /* POST body */
    StaticJsonDocument<128> postDoc;
    postDoc["passkey"] = passkey;

    String body;
    serializeJson(postDoc, body);

    int httpCode = http.POST(body);

    if (httpCode == 200) {

      String response = http.getString();
      Serial.println(response);

      StaticJsonDocument<256> doc;
      DeserializationError error = deserializeJson(doc, response);

      if (!error && doc["status"] == "success") {

        String action = doc["data"]["action"];

        if (action == "unlock") {
          Serial.println("Door UNLOCKED");
          servo.write(90);
          delay(1000);
          servo.write(0);
        }
        else if (action == "lock") {
          Serial.println("Door LOCKED");
          servo.write(0);
        }
      }
    }

    http.end();
  }

  delay(3000);  // poll every 3 seconds
}
