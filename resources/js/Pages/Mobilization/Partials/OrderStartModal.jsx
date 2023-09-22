import { Typography, Card, Space, Button, Empty, Form, Row, Col, Input, InputNumber, Divider, Descriptions, DatePicker, Upload, Select } from 'antd';
import { PlusOutlined, LoadingOutlined } from '@ant-design/icons';
import { Link, usePage, useForm } from '@inertiajs/react'
import dayjs from 'dayjs'
import { useEffect, useState } from 'react';

const { Title, Text } = Typography;


const OrderStartModal = ({ maintenance_types, contracts, maintenance }) => {

    const { permissions } = usePage().props?.auth || [];
    const isManager = permissions.includes('maintenance.manager');
    const isMoto = maintenance.vehicle.vehicle_type == 'Motocicleta';

    const itemMType = maintenance_types.map((item) => ({
        label: item.name,
        value: item.id
    }));

    const itemContract = contracts.map((item) => ({
        label: item.name,
        value: item.id
    }));

    const { data, setData, post, processing, errors } = useForm({
        identification: maintenance.user.identification || '',
        current_mileage: maintenance.vehicle.mileage || '',
        admission_date: dayjs(),
        admission_date_str: dayjs().format('YYYY-MM-DD HH:mm:ss'),
        img_vehicle: null,
        signature_responsibility: null,
        m_types_selected: [],
        c_selected: [],
        detail: '',
        user_id: maintenance.user.key,
        vehicle_id: maintenance.vehicle.key,
        maintenance_id: maintenance.key,
        price: 0
    });

    const [isSelected, setIsSelected] = useState(false);
    const [costMType, setCostMType] = useState([]);
    const [costContract, setCostContract] = useState([]);
    const [totalMType, setTotalMType] = useState(0);
    const [totalContract, setTotalContract] = useState(0);

    const handleChangeMT = (value) => {
        let totalMt = 0;
        let selectedCost = maintenance_types.filter((item) => value.includes(item.id));
        value.includes(1) && value.includes(2) ? setIsSelected(true) : setIsSelected(false);

        if (selectedCost.length) {
            totalMt = selectedCost.reduce((prev, curr) => {
                let pr = parseFloat(curr.price);
                isMoto && curr.id == 2 ? pr -= 20 : null;
                return prev + pr;
            }, 0);
        }
        setTotalMType(totalMt);
        setCostMType(selectedCost);
    };

    const handleChangeContract = (value) => {
        let totalMt = 0;
        let selectedCost = contracts.filter((item) => value.includes(item.id));
        if (selectedCost.length) {
            totalMt = selectedCost.reduce((prev, curr) => { return prev + parseFloat(curr.price); }, 0);
        }
        setTotalContract(totalMt);
        setCostContract(selectedCost);
    };


    const submit = (e) => {
        //console.log(data);
        let curr_price = ((totalContract + totalMType) + ((totalContract + totalMType) * .12)).toFixed(2);
        setData('price', curr_price);
        post(route('maintenance.store-order-start'), {
            onSuccess: () => {
            }
        });
    };

    const uploadButton = (
        <div>
            {processing ? <LoadingOutlined /> : <PlusOutlined />}
            <div
                style={{
                    marginTop: 8,
                }}
            >
                Cargar Imagen
            </div>
        </div>
    );

    return (
        <>
            < Title level={3} style={{ marginLeft: '5px', textAlign: 'center', marginTop: 8 }}>
                Generación Orden de Recepción
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
                        Orden de Recepcion
                    </Title>
                    <h1 className="flex-1 border-b-2 border-gray-100"></h1>
                </div>

                <Form.Item
                    label='Identificación Personal Entrega*'
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
                    <InputNumber size='large' style={{ width: '50%' }} min={0}></InputNumber>
                </Form.Item>

                <Form.Item
                    label='Horario de Ingreso*'
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
                            //setData('birthdate', e);
                        }}
                        disabledDate={(current) => {
                            return current && current.valueOf() < Date.now();
                        }}
                        placeholder="Ingresa el Horiario..."
                        //defaultValue={dayjs()}
                        popupClassName="custom-datepicker" 
                    />
                </Form.Item>

                <Form.Item
                    label='Imágen del Vehículo*'
                    name='img_vehicle'
                    valuePropName="img_vehicle"
                    validateStatus={errors.img_vehicle && 'error'}
                    help={errors.img_vehicle}
                    className='mb-4'
                >
                    <Upload
                        listType="picture-card"
                        customRequest={({ file, onSuccess }) => {
                            setTimeout(() => {
                                setData('img_vehicle', file);
                                onSuccess();
                            }, 1000);
                        }}
                        showUploadList={{ showPreviewIcon: false, showRemoveIcon: true }}
                        multiple
                        maxCount={1}
                        onRemove={() => {
                            setTimeout(() => {
                                setData('img_vehicle', null);
                            }, 1000);
                        }}
                    >
                        {uploadButton}
                    </Upload>
                </Form.Item>

                <Form.Item
                    label='Firma de Responsabilidad*'
                    name='signature_responsibility'
                    valuePropName="signature_responsibility"
                    validateStatus={errors.signature_responsibility && 'error'}
                    help={errors.signature_responsibility}
                    className='mb-4'
                >
                    <Upload
                        listType="picture-card"
                        customRequest={({ file, onSuccess }) => {
                            setTimeout(() => {
                                setData('signature_responsibility', file);
                                onSuccess();
                            }, 1000);
                        }}
                        showUploadList={{ showPreviewIcon: false, showRemoveIcon: true }}
                        multiple
                        maxCount={1}
                        onRemove={() => {
                            setTimeout(() => {
                                setData('signature_responsibility', null);
                            }, 1000);
                        }}
                    >
                        {uploadButton}
                    </Upload>
                </Form.Item>

                <div className="flex items-center mb-4">
                    <Title level={4} ellipsis style={{ margin: 0, padding: 0 }}>
                        Mantenimiento
                    </Title>
                    <h1 className="flex-1 border-b-2 border-gray-100"></h1>
                </div>

                <Form.Item
                    label='Tipo de Mantenimiento*'
                    name='m_types_selected'
                    valuePropName="m_types_selected"
                    validateStatus={errors.m_types_selected && 'error'}
                    help={errors.m_types_selected}
                    className='mb-4'
                >
                    <Select
                        mode='multiple'
                        allowClear
                        placeholder='Selecciona los mantenimientos'
                        options={itemMType}
                        style={{ width: '50%' }}
                        onChange={handleChangeMT}
                    />
                </Form.Item>
                {isSelected && (
                    <Text style={{ fontSize: '12px' }}>
                        Nota: No se permite mantenimiento 1 y 2 al mismo tiempo.
                    </Text>
                )}

                <Form.Item
                    label='Contratos*'
                    name='c_selected'
                    valuePropName="c_selected"
                    validateStatus={errors.c_selected && 'error'}
                    help={errors.c_selected}
                    className='mb-4'
                >
                    <Select
                        mode='multiple'
                        allowClear
                        placeholder='Selecciona los contratos'
                        options={itemContract}
                        style={{ width: '50%' }}
                        onChange={handleChangeContract}
                    />
                </Form.Item>

                <Form.Item
                    label='Detalles'
                    name='detail'
                    validateStatus={errors.detail && 'error'}
                    help={errors.detail}
                    className='mb-4'
                >
                    <Input.TextArea size='middle' placeholder='Detalles de la Orden'></Input.TextArea>
                </Form.Item>

                <div className="flex items-center mb-4">
                    <Title level={4} ellipsis style={{ margin: 0, padding: 0 }}>
                        Costos
                    </Title>
                    <h1 className="flex-1 border-b-2 border-gray-100"></h1>
                </div>
                {(costMType.length > 0) || (costContract.length > 0) ? (
                    <>
                        <Descriptions
                            bordered
                            column={{ xxl: 2, xl: 2, lg: 2, md: 2, sm: 2, xs: 2 }}
                            style={{ width: '100%', marginBottom: 20 }}
                            size='small'
                        >
                            {costMType.map((item) => {
                                return (
                                    <Descriptions.Item key={item.id} label={item.name} span={2}> {item.price} </Descriptions.Item>
                                );
                            })}
                            {costContract.map((item) => {
                                return (
                                    <Descriptions.Item key={item.id} label={item.name} span={2}> {item.price} </Descriptions.Item>
                                );
                            })}
                            <Descriptions.Item label="SUBTOTAL" span={1}> {(totalContract + totalMType).toFixed(2) || '0'} </Descriptions.Item>
                            <Descriptions.Item label="IVA 12%" span={1}> {((totalContract + totalMType) * .12).toFixed(2) || '0'} </Descriptions.Item>
                            <Descriptions.Item label="TOTAL" span={2}> {((totalContract + totalMType) + ((totalContract + totalMType) * .12)).toFixed(2) || '0'} </Descriptions.Item>
                        </Descriptions>
                    </>
                ) : (
                    <>
                        <Empty description='No se ha seleccionado ningún Mantenimiento/Contrato'>

                        </Empty>
                    </>
                )}

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

export default OrderStartModal;