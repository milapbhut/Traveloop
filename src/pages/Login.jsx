import { signInWithPopup } from "firebase/auth";
import { auth, provider } from "../firebase/firebase";
import { FcGoogle } from "react-icons/fc";

const Login = () => {

    const handleLogin = async () => {
        try {
            await signInWithPopup(auth, provider);
            alert("Login Successful");
        } catch (error) {
            console.log(error);
        }
    };

    return (
        <div className="min-h-screen bg-black flex items-center justify-center">

            <div className="bg-zinc-900 p-8 rounded-2xl w-[350px] shadow-xl">

                <h1 className="text-white text-3xl font-bold text-center mb-2">
                    Traveloop
                </h1>

                <p className="text-zinc-400 text-center mb-6">
                    Plan your journey smarter
                </p>

                <button
                    onClick={handleLogin}
                    className="w-full bg-white text-black py-3 rounded-xl flex items-center justify-center gap-2"
                >
                    <FcGoogle size={22} />
                    Sign in with Google
                </button>

            </div>

        </div>
    );
};

export default Login;