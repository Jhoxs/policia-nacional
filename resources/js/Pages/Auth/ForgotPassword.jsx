import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, useForm } from '@inertiajs/react';
import { Button, Checkbox, Form, Input } from 'antd';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('password.email'));
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            <div className="mb-4 text-sm text-gray-600">
                ¿Olvidaste tu contraseña? No hay problema, enviaremos a tu email un link con el que podrás restaurar tu contraseña.
            </div>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}

            <form onSubmit={submit}>
                <Input
                    id="email"
                    type="email"
                    name="email"
                    value={data.email}
                    className="mt-1 block w-full"
                    size="large"
                    onChange={(e) => setData('email', e.target.value)}
                    placeholder="Correo Electrónico"
                />

                <InputError message={errors.email} className="mt-2" />

                <div className="flex items-center justify-end mt-4 ">
                    <Button type="primary" size="large" className="ml-4 bg-cyan-600" disabled={processing} onClick={submit}>
                        Restablecimiento de contraseña
                    </Button>
                </div>
            </form>
        </GuestLayout>
    );
}
