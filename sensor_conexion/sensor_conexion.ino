#include <WiFi.h>
#include <HTTPClient.h>
#include <WiFiClientSecure.h>

const char* ssid = "MATEBOOK 7565";  
const char* password = "kakao2002";

String URL = "https://iotchaketinte.000webhostapp.com/insertar_temperatura.php"; // URL del servidor donde enviar los datos

const int lm35Pin = 32; // Pin al que está conectado el LM35
const int trigPin = 13; // Pin del ESP32 conectado al pin Trig del sensor ultrasónico
const int echoPin = 12; // Pin del ESP32 conectado al pin Echo del sensor ultrasónico
const int buzzerPin = 14; // Pin del ESP32 conectado al zumbador pasivo

void setup() {
  Serial.begin(115200);
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  pinMode(buzzerPin, OUTPUT);

  connectWiFi();
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    connectWiFi();
  }

  float temperature = readLM35();
  float distance = readUltrasonic();

  String postData = "temperature=" + String(temperature) + "&distance=" + String(distance);

  if (distance >= 11) {
    digitalWrite(buzzerPin, HIGH); // Activa el zumbador
  } else {
    digitalWrite(buzzerPin, LOW); // Desactiva el zumbador
  }

  WiFiClientSecure client;
  client.setInsecure(); // No verifiques el certificado SSL

  HTTPClient http;
  http.begin(client, URL);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(postData);
  String payload = "";

  if (httpCode > 0) {
    if (httpCode == HTTP_CODE_OK) {
      payload = http.getString();
      Serial.println(payload);
    } else {
      Serial.printf("[HTTP] POST... code: %d\n", httpCode);
    }
  } else {
    Serial.printf("[HTTP] POST... failed, error: %s\n", http.errorToString(httpCode).c_str());
  }

  http.end(); // Cerrar conexión

  Serial.print("URL: "); Serial.println(URL);
  Serial.print("Data: "); Serial.println(postData);
  Serial.print("httpCode: "); Serial.println(httpCode);
  Serial.print("payload: "); Serial.println(payload);
  Serial.println("--------------------------------------------------");
  delay(3000);
}

float readLM35() {
  int rawValue = analogRead(lm35Pin);
  Serial.print("Valor crudo LM35: "); Serial.println(rawValue);
  float voltage = (rawValue / 4095.0) * 3.3; // Convertir valor a voltaje (3.3V es el voltaje máximo en ESP32)
  Serial.print("Voltaje LM35: "); Serial.println(voltage);
  float temperatureC = voltage * 10.0; // Convertir voltaje a temperatura en grados Celsius (10mV por grado C)
  Serial.print("Temperatura LM35: "); Serial.println(temperatureC);

  return temperatureC;
}

float readUltrasonic() {
  digitalWrite(trigPin, LOW);
  delayMicroseconds(3);
  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);

  long duration = pulseIn(echoPin, HIGH);
  float distance = duration * 0.034 / 2;

  return distance;
}

void connectWiFi() {
  WiFi.mode(WIFI_OFF);
  delay(1000);
  WiFi.mode(WIFI_STA);

  WiFi.begin(ssid, password);
  Serial.println("Conectando a WiFi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.print("Conectado a: "); Serial.println(ssid);
  Serial.print("Dirección IP: "); Serial.println(WiFi.localIP());
}
