import { Button, Typography, Tooltip, Popconfirm, Space, DatePicker, Input, Row, Col, Card, Form, Select, notification } from 'antd';
import { Link, usePage, router, useForm } from '@inertiajs/react'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import React, { useState } from 'react';
import axios from 'axios';

const { Title, Text } = Typography;
const { RangePicker } = DatePicker;


const Index = ({ }) => {

    const [api, contextHolder] = notification.useNotification();

    const openNotificationWithIcon = (type) => {
        api[type]({
            message: 'Informes del Sistema',
            description:
                'No se encontraron datos dentro de los rangos especificados',
        });
    };

    const { data, setData, post, processing, errors, setError } = useForm({
        date_range: [],
        date_range_string: [],
        type_report: null,
    });

    const  submit = async (e) => {
        const urlHost = window.location.protocol + '//' + window.location.host + '/report';

        await axios({
            url: urlHost,
            method: 'post',
            data: {
                ...data
            },
            responseType: 'arraybuffer',
        }).then((response) => {

            setError('date_range', null);
            setError('type_report', null);

            if (response.status === 204) { openNotificationWithIcon('warning'); return; }

            const url = window.URL.createObjectURL(
                new Blob([response.data], { type: "application/csv" })
            );

            const link = document.createElement('a');
            document.body.appendChild(link);

            link.href = url;
            link.setAttribute('download', 'reporte-sistema.xlsx');
            link.click();

            // Cleanup.
            window.URL.revokeObjectURL(url);
            link.remove();

        }).catch((error) => {
            console.log('error', error);

            const encoder = new TextDecoder("utf-8");
            const e_data = new Uint8Array(error.response.data);

            const { errors: err } = JSON.parse(encoder.decode(e_data));

            if (err) {
                err.date_range ? setError('date_range', err.date_range) : setError('date_range', null);
                err.type_report ? setError('type_report', err.type_report) : setError('type_report', null);
            }

        })

        return false;
    };

    const option = [
        {
            value: 'user_report',
            label: 'Reporte de usuarios'
        }, {
            value: 'vehicle_report',
            label: 'Reporte de vehículos'
        }
    ];

    return (
        <>
            {contextHolder}
            <div className="flex items-center mt-2 mb-4">
                <Title level={2} ellipsis>
                    Informes del Sistema
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>

            <Row
                justify={'center'}
            >
                <Col
                    xs={{ span: 24 }} sm={{ span: 24 }} md={{ span: 18 }} lg={{ span: 14 }} xl={{ span: 8 }}
                >
                    <Card
                        title={
                            <>
                                <Title
                                    level={3}
                                >
                                    Descarga de Información
                                </Title>
                            </>
                        }

                        className='shadow-md'
                        headStyle={{ textAlign: 'center', paddingTop: 15, background: '#f5f5f5' }}
                    >

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
                            style={{ alignItems: 'center', alignContent: 'center' }}
                        >

                            <Form.Item
                                label='Tipo de Reporte'
                                name='type_report'
                                validateStatus={errors.type_report && 'error'}
                                help={errors.type_report}

                            >
                                <Select
                                    size='large'
                                    placeholder="Selecciona el tipo de reporte"
                                    options={option}
                                    allowClear
                                />
                            </Form.Item>

                            <Form.Item
                                label='Fecha de Búsqueda'
                                name='date_range'
                                validateStatus={errors.date_range && 'error'}
                                help={errors.date_range}

                            >
                                <RangePicker
                                    size='large'
                                    placeholder={['Fecha de inicio', 'Fecha de fin']}
                                    format={'YYYY-MM-DD'}
                                    style={{ width: '100%' }}

                                />
                            </Form.Item>



                            <Row align={'middle'} justify={'center'}>
                                <Col style={{ marginTop: 20 }}>
                                    <Button
                                        size='large'
                                        htmlType="submit"
                                        loading={processing}
                                    //onClick={submit}
                                    >
                                        Descargar
                                    </Button>
                                </Col>
                            </Row>


                        </Form>

                    </Card>
                </Col>
            </Row>

        </>
    );
}

Index.layout = page => (<AuthenticatedLayout title="Reportería" children={page} />)

export default Index;