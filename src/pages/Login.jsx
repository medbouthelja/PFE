import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuthStore } from '../store/authStore';
import { Leaf } from 'lucide-react';
import toast from 'react-hot-toast';

const Login = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const { login } = useAuthStore();
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);

    const result = await login(email, password);
    
    if (result.success) {
      toast.success('Connexion réussie');
      navigate('/dashboard');
    } else {
      toast.error(result.error || 'Erreur de connexion');
    }
    
    setLoading(false);
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-primary-50 to-primary-100 flex items-center justify-center p-4">
      <div className="max-w-md w-full">
        <div className="bg-white rounded-2xl shadow-xl p-8">
          <div className="text-center mb-8">
            <div className="inline-flex items-center justify-center w-16 h-16 bg-primary-100 rounded-full mb-4">
              <Leaf className="text-primary-600" size={32} />
            </div>
            <h1 className="text-3xl font-bold text-gray-900 mb-2">Green IT Platform</h1>
            <p className="text-gray-600">Connectez-vous à votre compte</p>
          </div>

          <form onSubmit={handleSubmit} className="space-y-6">
            <div>
              <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                Email
              </label>
              <input
                id="email"
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
                className="input-field"
                placeholder="votre@email.com"
              />
            </div>

            <div>
              <label htmlFor="password" className="block text-sm font-medium text-gray-700 mb-2">
                Mot de passe
              </label>
              <input
                id="password"
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
                className="input-field"
                placeholder="••••••••"
              />
            </div>

            <button
              type="submit"
              disabled={loading}
              className="w-full btn-primary py-3 disabled:opacity-50 disabled:cursor-not-allowed"
            >
              {loading ? 'Connexion...' : 'Se connecter'}
            </button>
          </form>

          <div className="mt-6 text-center text-sm text-gray-500 space-y-2">
            <p>
              Compte API (fixtures) : <span className="text-gray-700">admin@example.com</span> /{' '}
              <span className="text-gray-700">password</span>
            </p>
            <p className="text-xs max-w-sm mx-auto">
              Sans backend Symfony sur le port 8000, la connexion échoue. Lancez l’API depuis le dossier{' '}
              <code className="bg-gray-100 px-1 rounded">backend</code> ou activez{' '}
              <code className="bg-gray-100 px-1 rounded">VITE_DEMO_MODE=true</code> dans <code className="bg-gray-100 px-1 rounded">.env</code>{' '}
              pour un login local sans serveur.
            </p>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Login;

