import { Typography, Card, Space, Button, Empty, Form, Row, Col, Input, InputNumber, Divider, Descriptions, DatePicker, Upload, Select } from 'antd';
import { PlusOutlined, LoadingOutlined } from '@ant-design/icons';
import { Link, usePage, useForm } from '@inertiajs/react'
import dayjs from 'dayjs'
import { useEffect, useState } from 'react';

const { Title, Text } = Typography;

const OrderEndModal = ({ maintenance_types, contracts, maintenance }) => {
    const { permissions } = usePage().props?.auth || [];
    const isManager = permissions.includes('maintenance.manager');
    const isMoto = maintenance.vehicle.vehicle_type == 'Motocicleta';
    const n_mileage = isMoto ?  (parseInt(maintenance.vehicle.mileage) + 2000) :  (parseInt(maintenance.vehicle.mileage) + 5000);

    const { data, setData, post, processing, errors } = useForm({
        identification: maintenance.user.identification || '',
        current_mileage: maintenance.vehicle.mileage || '',
        next_mileage: n_mileage,
        admission_date: dayjs(),
        admission_date_str: dayjs().format('YYYY-MM-DD HH:mm:ss'),
        detail: '',
        user_id: maintenance.user.key,
        vehicle_id: maintenance.vehicle.key,
        maintenance_id: maintenance.key,
        price: 0
    });


    const submit = (e) => {
        //console.log(data);
        post(route('maintenance.store-order-end'), {
            onSuccess: () => {
            }
        });
    };


    return (
        <>
            < Title level={3} style={{ marginLeft: '5px', textAlign: 'center', marginTop: 8 }}>
                Generación Orden de Entrega
            </Title >

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
                style={{ width: '100%', paddingLeft: 25, paddingTop: 15, paddingRight: 25 }}
            >
                <Descriptions
                    title={
                        <>
                            <div className="flex items-center">
                                <Title level={4} ellipsis style={{ margin: 0, padding: 0 }}>
                                    Información Responsable
                                </Title>
                                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
                            </div>
                        </>
                    }
                    bordered
                    style={{ width: '100%', marginBottom: 20 }}
                    column={{ xxl: 2, xl: 2, lg: 2, md: 1, sm: 1, xs: 1 }}
                    size='small'
                >
                    <Descriptions.Item label="Nombre"> {maintenance.user.full_name || ''} </Descriptions.Item>
                    <Descriptions.Item label="Identificación"> {maintenance.user.identification || ''} </Descriptions.Item>
                </Descriptions>
                <Descriptions
                    title={
                        <>
                            <div className="flex items-center">
                                <Title level={4} ellipsis style={{ margin: 0, padding: 0 }}>
                                    Información Vehículo
                                </Title>
                                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
                            </div>
                        </>
                    }
                    bordered
                    column={{ xxl: 2, xl: 2, lg: 2, md: 1, sm: 1, xs: 1 }}
                    style={{ width: '100%', marginBottom: 20 }}
                    size='small'
                >
                    <Descriptions.Item label="Kilometraje"> {maintenance.vehicle.mileage || ''} </Descriptions.Item>
                    <Descriptions.Item label="Tipo de Vehículo"> {maintenance.vehicle.vehicle_type || ''} </Descriptions.Item>
                    <Descriptions.Item label="Número de Placa"> {maintenance.vehicle.plate || ''} </Descriptions.Item>
                    <Descriptions.Item label="Marca"> {maintenance.vehicle.brand || ''} </Descriptions.Item>
                    <Descriptions.Item label="Modelo"> {maintenance.vehicle.model || ''} </Descriptions.Item>
                </Descriptions>

                <div className="flex items-center mb-4">
                    <Title level={4} ellipsis style={{ margin: 0, padding: 0 }}>
                        Orden de Entrega
                    </Title>
                    <h1 className="flex-1 border-b-2 border-gray-100"></h1>
                </div>

                <Form.Item
                    label='Identificación Personal Retiro*'
                    name='identification'
                    validateStatus={errors.identification && 'error'}
                    help={errors.identification}
                    className='mb-4'
                >
                    <Input size='large' style={{ width: '50%' }}></Input>
                </Form.Item>

                <Form.Item
                    label='Kilometraje Actual*'
                    name='current_mileage'
                    validateStatus={errors.current_mileage && 'error'}
                    help={errors.current_mileage}
                    className='mb-4'
                >
                    <InputNumber disabled={true} size='large' style={{ width: '50%' }} min={0}></InputNumber>
                </Form.Item>

                <Form.Item
                    label='Proximo Kilometraje*'
                    name='next_mileage'
                    validateStatus={errors.next_mileage && 'error'}
                    help={errors.next_mileage}
                    className='mb-4'
                >
                    <InputNumber disabled={true} size='large' style={{ width: '50%' }} min={0}></InputNumber>
                </Form.Item>

                <Form.Item
                    label='Horario de Retiro*'
                    name='admission_date'
                    validateStatus={errors.admission_date_str && 'error'}
                    help={errors.admission_date_str}
                    className='mb-4'
                >
                    <DatePicker
                        className="w-full"
                        size="large"
                        style={{ width: '50%' }}
                        required
                        format={'YYYY-MM-DD HH:mm'}
                        showTime={{
                            format: 'HH:mm',
                        }}
                        onChange={(e, eString) => {
                            setData('admission_date_str', eString);
                        }}
                        disabledDate={(current) => {
                            return current && current.valueOf() < Date.now();
                        }}
                        placeholder="Ingresa el Horiario..."
                        popupClassName="custom-datepicker" 
                    />
                </Form.Item>

                <Form.Item
                    label='Observaciones'
                    name='detail'
                    validateStatus={errors.detail && 'error'}
                    help={errors.detail}
                    className='mb-4'
                >
                    <Input.TextArea size='middle' placeholder='Escribe las observaciones encontradas...'></Input.TextArea>
                </Form.Item>


                <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                    <Col>
                        <Button
                            type="primary"
                            htmlType="submit"
                            loading={processing}
                            size="large"
                            className="mt-5 bg-[#203956]"
                        >
                            Registrar Orden
                        </Button>
                    </Col>
                </Row>
            </Form>

        </>
    );
}

export default OrderEndModal;