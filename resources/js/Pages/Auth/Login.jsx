import { useEffect } from 'react';
//import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import { Button, Checkbox, Form, Input } from 'antd';
import { LockOutlined, UserOutlined } from '@ant-design/icons';
import ApplicationLogo from '@/Components/ApplicationLogo';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();

        post(route('login'));
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <div className='flex justify-center mb-10 mt-10'>
                <ApplicationLogo className="w-24 h-25 " />
            </div>

            <form onSubmit={submit}>
                <div>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 w-full"
                        size="large"
                        prefix={<UserOutlined className="site-form-item-icon" />} 
                        placeholder="Correo"
                        onChange={(e) => setData('email', e.target.value)}
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-6">
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 w-full"
                        size="large"
                        placeholder="Contraseña"
                        prefix={<LockOutlined className="site-form-item-icon" />}
                        onChange={(e) => setData('password', e.target.value)}
                    />

                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="block ml-1 mt-4">
                    <label className="flex items-center">
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            onChange={(e) => setData('remember', e.target.checked)}
                        />
                        <span className="ml-2 text-sm text-gray-600 ">Recuerdame</span>
                    </label>
                </div>

                <div className="flex flex-col items-center justify-center mt-4 mb-4 ">
                    <Button type="primary" size="large" className="mt-1 bg-cyan-600" disabled={processing} onClick={submit}>
                        Ingresar
                    </Button>

                    {canResetPassword && (
                        <Link
                            href={route('password.request')}
                            className="mt-5 mb-4 text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            ¿Olvidaste tu contraseña?
                        </Link>
                    )}
                </div>
            </form>
        </GuestLayout>
    );
}
