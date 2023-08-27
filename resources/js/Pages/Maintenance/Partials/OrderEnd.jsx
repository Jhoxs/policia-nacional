import { Typography, Card, Space, Button, Empty, Modal, Row, Col } from 'antd';
import { IdcardOutlined, UserOutlined, BgColorsOutlined, DownloadOutlined } from '@ant-design/icons';
import { Link, usePage, router } from '@inertiajs/react'
import React, { useState } from 'react';
import OrderEndModal from './OrderEndModal';

const { Title, Text } = Typography;

const OrderEnd = ({ maintenance, maintenance_types, contracts }) => {
    const { permissions } = usePage().props?.auth || [];
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [modelPreview, setModelPreview] = useState(false);
    const isManager = permissions.includes('maintenance.manager');
    const { order_end: o_end, order_start: o_start } = maintenance;

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

    return (
        <>
            < Title level={4} style={{ marginLeft: '5px' }}>
                Orden de Entrega
            </Title>
            {!maintenance.order_end && (
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
                        <OrderEndModal maintenance_types={maintenance_types} contracts={contracts} maintenance={maintenance}></OrderEndModal>

                    </Modal>
                    <Empty
                        style={{ padding: 50 }}
                        description={'La orden de entrega no ha sido generada.'}
                    >
                        {isManager && (
                            <>
                                <Button onClick={showModal()}>Generar Orden</Button>
                            </>
                        )}

                    </Empty>
                </>
            )}
            {maintenance.order_end && (
                <>
                    <Card style={{ marginTop: '20px', marginRight: '15px' }}>
                        <Card.Grid style={{...gridStyle}} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <IdcardOutlined style={{ fontSize: '30px' }} />
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> {o_end.u_receives.identification || ''} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Identificación Personal Recibe</div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={{...gridStyle}} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <UserOutlined style={{ fontSize: '30px' }} />
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> {o_end.u_receives.full_name || ''} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Nombre Personal Recibe</div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={gridStyle} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> {o_end.schedule || ''} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Hora de la Entrega</div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={gridStyle} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> {o_end.departure_date_formatted || ''} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Fecha de la Entrega</div>
                                </div>
                            </Space>
                        </Card.Grid>
                        <Card.Grid style={gridStyle} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <div className='sm:block'>
                                    <div>
                                        <Text strong> {o_end.next_mileage || ''} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Próximo Kilometraje</div>
                                </div>
                            </Space>
                        </Card.Grid>

                        <Card.Grid style={gridStyle} hoverable={false}>
                            <Space size={20} style={spaceStyle}>
                                <div className='sm:block'>
                                    <div>
                                        <Text strong italic={!!o_end.detail}> {o_end.detail || '<< No se existen detalles >>'} </Text>
                                    </div>
                                    <div style={{ color: 'rgba(0, 0, 0, 0.6)' }}>Observaciones</div>
                                </div>
                            </Space>
                        </Card.Grid>
                    </Card>

                    <Row justify={'center'} align={'middle'} gutter={['10', '10']} className='mt-4'>
                        <Col>

                            <Button
                                icon={<BgColorsOutlined />}
                                onClick={() => {
                                    window.print();

                                }}
                                style={{ marginTop: 5 }}
                            >
                                Imprimir
                            </Button>

                        </Col>
                        <Col>
                            <Button
                                icon={<DownloadOutlined />}
                                style={{ marginTop: 5 }}
                                onClick={ async e => {
                                    //router.post('/download-maintenance-report',{...maintenance});
                                    e.preventDefault();
                                    
                                    const urlHost = window.location.protocol + '//' + window.location.host + '/download-maintenance-report';

                                    await axios({
                                        url: urlHost,
                                        method: 'post',
                                        data: {
                                            ...maintenance
                                        },
                                        responseType: 'arraybuffer'
                                    }).then((response) => {

                                        const url = window.URL.createObjectURL(
                                            new Blob([response.data], { type: "application/pdf" })
                                        );

                                        const link = document.createElement('a');
                                        document.body.appendChild(link);

                                        link.href = url;
                                        link.setAttribute('download', 'reporte-mantenimiento.pdf');
                                        link.click();

                                        // Cleanup.
                                        window.URL.revokeObjectURL(url);
                                        link.remove();

                                    }).catch((error) => {
                                        console.log('error', error);
                                    })

                                    return false;
                                }}
                            >
                                Descargar
                            </Button>
                        </Col>
                    </Row>
                </>
            )}
        </>
    );
}

export default OrderEnd;