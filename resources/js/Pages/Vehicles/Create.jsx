import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space, Card, DatePicker, Select } from 'antd';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { MailOutlined, IdcardOutlined, FileSearchOutlined, DashboardOutlined, BugOutlined, VerifiedOutlined, PicCenterOutlined, VerticalAlignTopOutlined, SlidersOutlined, TeamOutlined } from '@ant-design/icons';

const { Text, Title } = Typography;


const Create = ({ vehicle_type }) => {

    const { data, setData, post, processing, errors } = useForm({
        plate: '',
        chassis: '',
        brand: '',
        model: '',
        motor: '',
        mileage: '',
        cylinder_capacity: '',
        loading_capacity: '',
        passenger_capacity: '',
        vehicle_type: ''
    });

    const submit = (e) => {
        //console.log(data);
        post(route('vehicle.store'), {
            onSuccess: () => {
            }
        });
    };

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Creación de Vehículo
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
                            label='Placa'
                            name='plate'
                            validateStatus={errors.plate && 'error'}
                            help={errors.plate}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<IdcardOutlined />}></Input>
                        </Form.Item>

                        <Form.Item
                            label='Chasis'
                            name='chassis'
                            validateStatus={errors.chassis && 'error'}
                            help={errors.chassis}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<BugOutlined />}></Input>
                        </Form.Item>

                        <Form.Item
                            label='Marca'
                            name='brand'
                            validateStatus={errors.brand && 'error'}
                            help={errors.brand}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<VerifiedOutlined />}></Input>
                        </Form.Item>
                        <Form.Item
                            label='Modelo'
                            name='model'
                            validateStatus={errors.model && 'error'}
                            help={errors.model}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<FileSearchOutlined />}></Input>
                        </Form.Item>
                        <Form.Item
                            label='Motor'
                            name='motor'
                            validateStatus={errors.motor && 'error'}
                            help={errors.motor}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<PicCenterOutlined />}></Input>
                        </Form.Item>
                        <Form.Item
                            label='Kilometraje'
                            name='mileage'
                            validateStatus={errors.mileage && 'error'}
                            help={errors.mileage}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<DashboardOutlined />}></Input>
                        </Form.Item>
                        <Form.Item
                            label='Capacidad de Cilindraje'
                            name='cylinder_capacity'
                            validateStatus={errors.cylinder_capacity && 'error'}
                            help={errors.cylinder_capacity}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<SlidersOutlined />}></Input>
                        </Form.Item>
                        <Form.Item
                            label='Capacidad de Carga'
                            name='loading_capacity'
                            validateStatus={errors.loading_capacity && 'error'}
                            help={errors.loading_capacity}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<VerticalAlignTopOutlined />}></Input>
                        </Form.Item>
                        <Form.Item
                            label='Número de Pasajeros'
                            name='passenger_capacity'
                            validateStatus={errors.passenger_capacity && 'error'}
                            help={errors.passenger_capacity}
                            className='mb-4'
                        >
                            <Input size='large' prefix={<TeamOutlined />}></Input>
                        </Form.Item>

                        <Form.Item
                            label='Tipo de Vehículo'
                            name='vehicle_type'
                            validateStatus={errors.vehicle_type && 'error'}
                            help={errors.vehicle_type}
                            className='mb-4'
                        >
                            <Select
                                size='large'
                                placeholder='Roles Disponibles'
                                options={vehicle_type}
                            />

                        </Form.Item>


                        <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                            <Col>
                                <Link href={route('vehicle.index')}>
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
                                    Registrar
                                </Button>
                            </Col>
                        </Row>


                    </Form>
                </Card.Grid>
            </div>

        </>

    );
}


Create.layout = page => (<AuthenticatedLayout title="Agregar Vehículo" children={page} />)


export default Create

