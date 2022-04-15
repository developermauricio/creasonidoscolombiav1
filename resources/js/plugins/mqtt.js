import mqtt from 'mqtt';

// const connection = {
//     host: "broker.emqx.io",
//     port: 8083,
//     endpoint: "/mqtt",
//     clean: true,
//     connectTimeout: 4000,
//     reconnectPeriod: 4000,
//     // Certification Information
//     clientMQId: "mqttjs_3be2c321",
//     username: "emqx_test",
//     password: "emqx_test",
// };

const connection = {
    host: "mqtt.socket-aicode.art",
    port: 8083,
    endpoint: "/mqtt",
    clean: true,
    connectTimeout: 4000,
    reconnectPeriod: 4000,
    // Certification Information
    clientMQId: "mqttjs_3be2c321",
    username: "mqtt",
    password: "HVH1RpPLiB2hxI5VwKoY",
};

let clientMQ = {
    connected: false,
};

const callbacks = {

};

const createConnection = () => {
    const { host, port, endpoint, ...options } = connection;
    const connectUrl = `wss://${host}:${port}${endpoint}`;
    try {
        clientMQ = mqtt.connect(connectUrl, options);
    } catch (error) {
        console.log("mqtt.connect error", error);
    }

    clientMQ.on("connect", () => {
        console.log("Connection succeeded!");
    });

    clientMQ.on("error", (error) => {
        console.log("Connection failed", error);
    });

    clientMQ.on("message", (topic, message) => {
        if (callbacks[topic]) {
            Object.keys(callbacks[topic]).forEach(key => {
                const callback = callbacks[topic][key];
                callback(message.toString());
            });
        } else {
            console.log(`Received message ${message} from topic ${topic}`);
        }
    });
};

createConnection();

export const subscriberMQTT = (key, topic, callback, config = { qos: 0, retain: false }) => {
    return new Promise((resolve, reject) => {
        clientMQ.subscribe(topic, config, (error, res) => {
            if (error) {
                console.log("Subscribe to topics error", error);
                reject(error);
                return;
            }
            if (!callbacks[topic]) {
                callbacks[topic] = {};
            }
            callbacks[topic][key] = callback;
            resolve(res);
        });
    })
};

export const isConnectedMQTT = () => {
    return clientMQ.connected;
}

export const publishMQTT = (topic, payload) => {
    return new Promise((resolve, reject) => {
        let payloadSend = payload;
        if (!payload.charAt) {
            payloadSend = JSON.stringify(payload)
        }
        clientMQ.publish(topic, payloadSend, 0, (error) => {
            if (error) {
                console.log("Publish error", error);
                reject(error)
            }
        });
        resolve(payload)
    })
}
