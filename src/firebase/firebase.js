import { initializeApp } from "firebase/app";
import { getAuth, GoogleAuthProvider } from "firebase/auth";

const firebaseConfig = {
  apiKey: "AIzaSyAXQ7nIIUN5EoUy9FLmNEYafC-hpzpok7I",
  authDomain: "traveloop-72342.firebaseapp.com",
  projectId: "traveloop-72342",
  storageBucket: "traveloop-72342.firebasestorage.app",
  messagingSenderId: "474448576735",
  appId: "1:474448576735:web:3310b8b82fcec19ebf296a"
};

const app = initializeApp(firebaseConfig);

export const auth = getAuth(app);
export const provider = new GoogleAuthProvider();