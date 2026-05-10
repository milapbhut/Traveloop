import { signInWithPopup } from "firebase/auth";
import { auth, provider } from "../firebase/firebase";
import { FcGoogle } from "react-icons/fc";

const Login = () => {

  const handleLogin = async () => {
    try {
      await signInWithPopup(auth, provider);
      alert("Login Successful ✅");
    } catch (error) {
      console.log(error);
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-black via-zinc-900 to-black flex items-center justify-center px-4">

      <div className="bg-zinc-900/80 backdrop-blur-lg border border-zinc-800 p-10 rounded-3xl w-full max-w-md shadow-2xl">

        <h1 className="text-4xl font-bold text-white text-center mb-2">
          Traveloop
        </h1>

        <p className="text-zinc-400 text-center mb-8">
          Plan smarter journeys ✈️
        </p>

        <button
          onClick={handleLogin}
          className="w-full bg-white hover:bg-zinc-200 transition text-black font-semibold py-3 rounded-xl flex items-center justify-center gap-3"
        >
          <FcGoogle size={24} />
          Continue with Google
        </button>

      </div>

    </div>
  );
};

export default Login;