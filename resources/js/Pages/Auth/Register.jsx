import { useEffect } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import { DatePicker, Input, InputNumber, Select, Button } from 'antd';
import { PlusOutlined, UserOutlined, PhoneOutlined } from '@ant-design/icons';
export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        lastname:'',
        identification:'',
        phone:'',
        birthdate: '',
        birthdate_string: '',
        city:'',
        blood_type:'',
        rank:'',
        email: '',
        password: '',
        password_confirmation: '',
    });

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();

        post(route('register'));
    };

    const dateFormat = 'YYYY-MM-DD';

    return (
        <GuestLayout>
            <Head title="Register" />

            <form onSubmit={submit}>
                <div>
                    <InputLabel htmlFor="name" value="Nombre" />

                    <Input
                        id="name"
                        name="name"
                        autoComplete="name"
                        size="large"
                        value={data.name}
                        className="mt-1 block w-full"
                        autoFocus={true}
                        onChange={(e) => setData('name', e.target.value)}
                        required
                    />

                    <InputError message={errors.name} className="mt-2" />
                </div>

                <div className="mt-4"> 
                    <InputLabel htmlFor="lastname" value="Apellido"/>

                    <Input
                        id="lastname"
                        name="lastname"
                        autoComplete="lastname"
                        size="large"
                        value={data.lastname}
                        className="mt-1 block w-full"
                        autoFocus={true}
                        onChange={(e) => setData('lastname', e.target.value)}
                        required
                    />

                    <InputError message={errors.lastname} className="mt-2" />
                </div>
                
                <div className="mt-4"> 
                    <InputLabel htmlFor="identification" value="Identificacion"/>

                    <Input
                        id="identification"
                        name="identification"
                        autoComplete="identification"
                        size="large"
                        value={data.identification}
                        autoFocus={true}
                        onChange={(e) => {
                            let first_digit = e.target.value ? e.target.value.substring(0,10): null;
                            errors.identification = e.target.value.toString().length > 11 ? 'No se aceptan mas de 10 caracteres' : null; 
                            setData('identification', first_digit)
                        }}
                        status={errors.identification ? 'error' : null}
                        required
                        className="mt-1 w-full"
                        prefix={<UserOutlined />}
                        
                    />

                    <InputError message={errors.identification} className="mt-2" />
                </div>
                
                <div className="mt-4"> 
                    <InputLabel htmlFor="phone" value="Teléfono"/>

                    <Input
                        id="phone"
                        name="phone"
                        size="large"
                        value={data.phone}
                        autoComplete="phone"
                        autoFocus={true}
                        onChange={(e) => {
                            let first_digit = e.target.value ? e.target.value.substring(0,10): null;
                            errors.phone = e.target.value.toString().length > 11 ? 'No se aceptan mas de 10 caracteres' : null; 
                            setData('phone', first_digit)
                        }}
                        status={errors.phone ? 'error' : null}
                        required
                        className="mt-1 w-full"
                        prefix={<PhoneOutlined />}
                    />

                    <InputError message={errors.phone} className="mt-2" />
                </div>



                <div className="mt-4">
                    <InputLabel htmlFor="birthdate" value="Fecha de Nacimiento"/>
                    <DatePicker
                        id="birthdate"
                        name="birthdate"
                        value={data.birthdate}
                        className="mt-1 block w-full"
                        onChange={(e, eString) => {
                            data.birthdate_string = eString;
                            setData('birthdate', e);}}
                        size="large"
                        autoComplete="birthdate"
                        required
                        disabledDate={(current)=>{
                            return current && current.valueOf() > Date.now();
                        }}
                        placeholder="Selecciona tu fecha de nacimiento"
                        format={dateFormat}
                    />
                </div>
                
                <div className="mt-4">
                    <InputLabel htmlFor="city" value="Ciudad de Nacimiento"/>
                    <Select
                        id="city"
                        name="city"
                        defaultValue=""
                        className="mt-1 block w-full"
                        onChange={(e) => {
                            setData('city',e);
                        }}
                        size="large"
                        options={[
                            {value:'QUITO',label:'Quito'},
                            {value:'GUAYAQUIL',label:'Guayaquil'}

                        ]}
                        showSearch
                        optionFilterProp="children"
                        filterOption={(input, option) =>
                            (option?.label ?? '').toLowerCase().includes(input.toLowerCase())
                        }
                        required
                    />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="blood_type" value="Tipo de Sangre"/>
                    <Select
                        id="blood_type"
                        name="blood_type"
                        defaultValue=""
                        className="mt-1 block w-full"
                        onChange={(e) => {
                            setData('blood_type',e);
                        }}
                        size="large"
                        options={[
                            {value:'O-POSITIVO',label:'O +'},
                            {value:'O-NEGATIVO',label:'O -'}

                        ]}
                        required
                    />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="rank" value="Rango"/>
                    <Select
                        id="rank"
                        name="rank"
                        defaultValue=""
                        className="mt-1 block w-full"
                        onChange={(e) => {
                            setData('rank',e);
                        }}
                        size="large"
                        options={[
                            {value:'cadete',label:'Cadete'},
                            {value:'comandante',label:'Comandante'}

                        ]}
                        required
                    />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="email" value="Email" />

                    <Input
                        id="email"
                        type="email"
                        name="email"
                        size="large"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        onChange={(e) => setData('email', e.target.value)}
                        required
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" />

                    <Input.Password
                        id="password"
                        type="password"
                        name="password"
                        size="large"
                        value={data.password}
                        autoComplete="new-password"
                        onChange={(e) => setData('password', e.target.value)}
                        required
                    />

                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password_confirmation" value="Confirm Password" />

                    <Input.Password
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        size="large"
                        autoComplete="new-password"
                        onChange={(e) => setData('password_confirmation', e.target.value)}
                        required
                    />

                    <InputError message={errors.password_confirmation} className="mt-2" />
                </div>

                <div className="flex items-center justify-center mt-4">
                    {/* <Link
                        href={route('login')}
                        className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Ya estas registrado?
                    </Link> */}

                    <Button type="primary" size="large" className="ml-4 mt-2 bg-cyan-600" disabled={processing} onClick={submit}>
                        Registrar
                    </Button>
                </div>
            </form>
        </GuestLayout>
    );
}
