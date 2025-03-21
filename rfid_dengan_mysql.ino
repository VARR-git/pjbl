#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 2   // Pin untuk RFID
#define RST_PIN 0 // Pin reset RFID

const char* ssid = "AVIR"; 
const char* password = "1207V23R";
const char* serverURL = "http://192.168.1.7/pjbl/connect_rfid.php"; // URL API PHP

MFRC522 mfrc522(SS_PIN, RST_PIN);
WiFiClient client;

void setup() {
    Serial.begin(9600);
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }
    Serial.println("\nWiFi Connected!");

    SPI.begin();
    mfrc522.PCD_Init();
    Serial.println("RFID Scanner Ready...");
}

void loop() {
    if (!mfrc522.PICC_IsNewCardPresent() || !mfrc522.PICC_ReadCardSerial()) {
        return;
    }

    // Baca UID dan konversi ke desimal
    String uid = "";
    for (byte i = 0; i < mfrc522.uid.size; i++) {
        uid += String(mfrc522.uid.uidByte[i]);
    }
    Serial.println("UID: " + uid);

    // Kirim UID ke server
    if (WiFi.status() == WL_CONNECTED) {
        HTTPClient http;
        http.begin(client, serverURL);
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");

        String postData = "uid=" + uid;
        Serial.print("Mengirim data ke: ");
        Serial.println(serverURL);
        Serial.println("Data: " + postData);
        int httpResponseCode = http.POST(postData);

        if (httpResponseCode > 0) {
            String response = http.getString();
            Serial.println("Response: " + response);
        } else {
            Serial.print("WiFi Status: ");
            Serial.println(WiFi.status());

            Serial.print("Error: ");
            Serial.println(httpResponseCode);
        }
        http.end();
    } else {
        Serial.println("WiFi tidak terhubung!");
    }

    delay(3000); // Tunggu sebelum membaca kartu berikutnya
}
