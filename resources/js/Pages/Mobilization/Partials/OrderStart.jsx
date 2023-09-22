import { Typography, Card, Space, Button, Empty, Modal, Image } from 'antd';
import { IdcardOutlined, UserOutlined } from '@ant-design/icons';
import { Link, usePage } from '@inertiajs/react'
import React, { useState } from 'react';
import OrderStartModal from './OrderStartModal';


const { Title, Text } = Typography;


const OrderStart = ({ maintenance, maintenance_types, contracts }) => {

    const { permissions } = usePage().props?.auth || [];
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [modelPreview, setModelPreview] = useState(false);
    const isManager = permissions.includes('maintenance.manager');
    const { maintenance_types: mt_used, order_start: o_start, contracts: c_used } = maintenance;

    const handleCancel = () => {
        setIsModalOpen(false);
    };

    const showModal = data => e => {
        setModelPreview(data);
        setIsModalOpen(true);
    };

    const gridStyle = {
        width: '100%',
        padding: '10px'

    };

    const imgStyle = {
        borderRadius: '50%',
        width: 95,
        height: 80
    };

    const spaceStyle = {
        paddingLeft: '15px'
    };

    const joinedMT = mt_used.map((mt) => mt.name).join(", ");
    const joinedC = c_used.map((c) => c.name).join(", ");

    return (
        <>
            < Title level={4} style={{ marginLeft: '5px' }}>
                Orden de Recepción
            </Title >
            {!maintenance.order_start && (
                <>
                    <Modal
                        style={{ top: 34 }}
                        open={isModalOpen}
                        closable={false}
                        onCancel={handleCancel}
                        okButtonProps={{
                            hidden: true,
                        }}
                        cancelButtonProps={{
                            hidden: true,
                        }}
                        width={'50em'}
                    >
                        <OrderStartModal maintenance_types={maintenance_types} contracts={contracts} maintenance={maintenance}></OrderStartModal>

                    </Modal>
                    <Empty
                        style={{ padding: 50 }}
                        description={'La orden de recepción no ha sido generada.'}
                    >
                        {isManager && (
                            <>
                                <Button onClick={showModal()}>Generar Orden</Button>
                            </>
                        )}

                    </Empty>
                </>
            )}
            {maintenance.order_start && (
                <>
                    <Card style={{ marginTop: '20px', marginRight: '15px' }}>
                        <Card.Grid style={{...gridStyle}} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <IdcardOutlined style={{ fontSize: '30px' }} />
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> {o_start.u_delivery.identification || ''} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Identificación Personal Entrega</div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={{...gridStyle}} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <UserOutlined style={{ fontSize: '30px' }} />
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> {o_start.u_delivery.full_name || ''} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Nombre Personal Entrega</div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={{ ...gridStyle }} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <Image
                                    src={o_start.img_vehicle}
                                    style={imgStyle}
                                />
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> Imagen del vehículo </Text>
                                    </div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={{ ...gridStyle }} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <Image
                                    src={o_start.signature_responsibility}
                                    style={imgStyle}
                                />
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> Firma de Responsabilidad </Text>
                                    </div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={gridStyle} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> {o_start.schedule || ''} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Hora de la Recepción</div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={gridStyle} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> {o_start.admission_date_formatted || ''} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Fecha de la Recepción</div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={gridStyle} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> {o_start.current_mileage || ''} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Kilometraje Actual</div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={gridStyle} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <div className='sm:block'>
                                    <div>
                                        <Text strong > {joinedMT || ' '} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Mantenimientos Seleccionados</div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={gridStyle} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <div className='sm:block'>
                                    <div>
                                        <Text strong > {joinedC || ' '} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Contratos Seleccionados</div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={gridStyle} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <div className='sm:block'>
                                    <div>
                                        <Text strong italic={!!o_start.detail}> {o_start.detail || '<< No se existen detalles >>'} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Detalles Adicionales</div>
                                </div>
                            </Space>
                        </Card.Grid>

                    </Card>
                </>
            )}
        </>
    );
}

export default OrderStart;