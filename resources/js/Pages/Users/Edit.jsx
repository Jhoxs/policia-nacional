import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space, Card, DatePicker, Select } from 'antd';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { MailOutlined, UserOutlined, PhoneOutlined } from '@ant-design/icons';
import dayjs from 'dayjs';

const { Text, Title } = Typography;


const Edit = ({ roles, cities, blood_types, ranks, userInfo }) => {

    const user = userInfo?.data;
    const dateFormatted =  dayjs(user?.birthdate_form);

    const { data, setData, patch, processing, errors } = useForm({
        name: user?.name,
        lastname: user?.last_name,
        identification: user?.identification,
        phone: user?.phone,
        birthdate: dateFormatted,
        city: user?.city,
        blood_type: user?.blood_type,
        rank: user?.rank,
        email: user?.email,
        roles: user?.roles
    });

    const submit = (e) => {
        patch(route('user.update',user?.key), {
            onSuccess: () => {
            }
        });
    };

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Edición de Usuario
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <div className="flex justify-center mt-5'">
                <Card.Grid className='flex justify-center shadow-md' style={{ maxWidth: 800, width: 550, padding: 15, borderRadius: 12 }}>
                    <Form
                        name="basic"
                        layout='vertical'
                        initialValues={data}
                        onFieldsChange={(changedFields) => {
                            changedFields.forEach(item => {
                                setData(item.name[0], item.value);
                            })
                        }}
                        onFinish={submit}
                        autoComplete="off"
                        scrollToFirstError
                        className='m-4 w-full'

                    >
                        <Form.Item
                            label='Nombre'
                            name='name'
                            validateStatus={errors.name && 'error'}
                            help={errors.name}
                            className='mb-4'
                        >
                            <Input size='large'></Input>
                        </Form.Item>

                        <Form.Item
                            label='Apellido'
                            name='lastname'
                            validateStatus={errors.lastname && 'error'}
                            help={errors.lastname}
                            className='mb-4'
                        >
                            <Input size='large'></Input>
                        </Form.Item>

                        <Form.Item
                            label='Identificación'
                            name='identification'
                            validateStatus={errors.identification && 'error'}
                            help={errors.identification}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<UserOutlined />}></Input>
                        </Form.Item>
                        <Form.Item
                            label='Teléfono'
                            name='phone'
                            validateStatus={errors.phone && 'error'}
                            help={errors.phone}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<PhoneOutlined />}></Input>
                        </Form.Item>
                        <Form.Item
                            label='Fecha de Nacimiento'
                            name='birthdate'
                            validateStatus={errors.birthdate && 'error'}
                            help={errors.birthdate}
                            className='mb-4'
                        >
                            <DatePicker
                                className="w-full"
                                size="large"
                                required
                                disabledDate={(current) => {
                                    return current && current.valueOf() > Date.now();
                                }}
                                placeholder="Selecciona tu fecha de nacimiento"
                            />
                        </Form.Item>
                        <Form.Item
                            label='Ciudad de Nacimiento'
                            name='city'
                            validateStatus={errors.city && 'error'}
                            help={errors.city}
                            className='mb-4'
                        >
                            <Select
                                size="large"
                                options={cities}
                                showSearch
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    (option?.label ?? '').toLowerCase().includes(input.toLowerCase())
                                }
                            />
                        </Form.Item>
                        <Form.Item
                            label='Tipo de Sangre'
                            name='blood_type'
                            validateStatus={errors.blood_type && 'error'}
                            help={errors.blood_type}
                            className='mb-4'
                        >
                            <Select
                                size="large"
                                options={blood_types}
                                showSearch
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    (option?.label ?? '').toLowerCase().includes(input.toLowerCase())
                                }
                            />
                        </Form.Item>
                        <Form.Item
                            label='Rango'
                            name='rank'
                            validateStatus={errors.rank && 'error'}
                            help={errors.rank}
                            className='mb-4'
                        >
                            <Select
                                size="large"
                                options={ranks}
                                showSearch
                                optionFilterProp="children"
                                filterOption={(input, option) =>
                                    (option?.label ?? '').toLowerCase().includes(input.toLowerCase())
                                }
                            />
                        </Form.Item>
                        <Form.Item
                            label='Correo Electrónico'
                            name='email'
                            validateStatus={errors.email && 'error'}
                            help={errors.email}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<MailOutlined />}></Input>
                        </Form.Item>
                        
                        <Form.Item
                            label='Roles'
                            name='roles'
                            validateStatus={errors.roles && 'error'}
                            help={errors.roles}
                            className='mb-4'
                        >
                             <Select
                                size='large'
                                mode='tags'
                                placeholder='Roles Disponibles'
                                options={roles}
                            />
                            
                        </Form.Item>


                        <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                            <Col>
                                <Link href={route('user.index')}>
                                    <Button
                                        loading={processing}
                                        size="large"
                                        className="mt-5 shadow-md"
                                    >
                                        Volver
                                    </Button>
                                </Link>
                            </Col>
                            <Col>
                                <Button
                                    type="primary"
                                    htmlType="submit"
                                    loading={processing}
                                    size="large"
                                    className="mt-5 bg-[#203956]"
                                >
                                    Actualizar
                                </Button>
                            </Col>
                        </Row>


                    </Form>
                </Card.Grid>
            </div>

        </>

    );
}


Edit.layout = page => (<AuthenticatedLayout title="Editar Usuario" children={page} />)


export default Edit

