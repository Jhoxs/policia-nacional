import { Typography, Button, Divider, Form, Input, Checkbox, Row, Col, Space, Card, DatePicker, InputNumber, Table } from 'antd';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { MailOutlined, UserOutlined, PhoneOutlined } from '@ant-design/icons';
import dayjs from 'dayjs';
import InputLabel from '@/Components/InputLabel';
import InputError from '@/Components/InputError';

const { Text, Title } = Typography;


const Edit = ({ modelInfo, sparesSelected, modelData }) => {

    const { data:contractData } = modelData;
    const { data, setData, patch, processing, errors } = useForm({
        name: contractData.name || '',
        prices: contractData.price,
        spareSelected: sparesSelected || [],
        detail: contractData.detail,
    });

    const column = [
        {
            title: 'Repuesto',
            dataIndex: 'name',
            width: '40%',
            align: 'Left'
        },
        {
            title: 'Marca',
            dataIndex: 'brand',
            width: '40%',
            align: 'Left'
        },
        {
            title: 'Precio',
            dataIndex: 'price',
            width: '20%',
            align: 'center'
        }
    ];

    //SECCION TABLA
    const { data: dataSource, meta } = modelInfo || { data: {}, meta: {} };
    const [selectedRowKeys, setSelectedRowKeys] = useState(sparesSelected || []);
    const [loading, setLoading] = useState(false);

    const onSelectOne = (record, selected, selectedRows) => {
        setLoading(true);
        const { key } = record;

        if (selected) {
            //Guarda la informacion de los array
            const prevInfo = selectedRowKeys;
            prevInfo.push(key);
            //Evita los datos duplicados
            const uniqueSelectedRowKeys = Array.from(new Set(prevInfo)).filter(Boolean);
            setSelectedRowKeys(uniqueSelectedRowKeys);
            setData('spareSelected', uniqueSelectedRowKeys);
            setLoading(false);
        } else {
            const prevFilter = selectedRowKeys;
            const shiftedArray = prevFilter.filter((element) => element !== key);
            setSelectedRowKeys(shiftedArray);
            setLoading(false);
            setData('spareSelected', shiftedArray);
        }
    };
    const rowSelection = {
        selectedRowKeys,
        onSelect: onSelectOne,
        hideSelectAll: true
    };

    const links = meta?.links;

    const state = {
        dataSource: dataSource,
        pagination: {
            total: meta.total || 0,
            pageSize: meta.per_page || 0,
            current: meta.current_page || 0,
            showTotal: (total, range) => `${range[0]}-${range[1]} de ${total} Datos`
        },
        filters: {},
        loading: false
    }

    const { pagination } = state;

    const handleTableChange = (pagination, filters) => {
        const { url } = { ...links.find((link) => link.label == pagination.current) };

        //Send data from url 
        router.visit(url, {
            preserveScroll: true,
            preserveState: true,
            replace: true
        });

    };
    //FIN SECCION TABLA

    const submit = (e) => {
        patch(route('contract.update',contractData?.key), {
            onSuccess: () => {
            }
        });
    };

    return (
        <>
            <div className="flex items-center mt-2 mb-4">
                <Title level={1} ellipsis>
                    Edición del Contrato
                </Title>
                <h1 className="flex-1 border-b-2 border-gray-100"></h1>
            </div>
            <div className="flex justify-center mt-5'">
                <Card.Grid className='flex justify-center shadow-md' style={{ maxWidth: 800, width: 750, padding: 15, borderRadius: 12 }}>
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
                            label='Nombre del Contrato*'
                            name='name'
                            validateStatus={errors.name && 'error'}
                            help={errors.name}
                            className='mb-4'
                        >
                            <Input size='large'></Input>
                        </Form.Item>

                        <Form.Item
                            label='Precio'
                            name='prices'
                            validateStatus={errors.prices && 'error'}
                            help={errors.prices}
                            className='mb-4'
                        >
                            <InputNumber
                                style={{ width: '50%' }}
                                size='large'
                                prefix="$"
                                min="0"
                                stringMode
                                disabled={true}
                            />
                        </Form.Item>
                        <Form.Item
                            label='Detalles'
                            name='detail'
                            validateStatus={errors.phone && 'error'}
                            help={errors.phone}
                            className='mb-4'
                        >
                            <Input.TextArea size='large'></Input.TextArea>
                        </Form.Item>

                        <div className="mt-5">
                            <InputLabel htmlFor="Repuestos*" value="Repuestos*" className='mb-2' />
                            <Table
                                columns={column}
                                dataSource={dataSource}
                                rowSelection={rowSelection}
                                pagination={pagination}
                                onChange={handleTableChange}
                            />
                            <InputError message={errors.spareSelected} className="mt-2 text-[#ff4d4f]" />
                        </div>

                        <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                            <Col>
                                <Link href={route('contract.index')}>
                                    <Button
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

